<?php

declare(strict_types=1);

namespace MCA7\LevelLimiter;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;
use pocketmine\{event\Player, 
    event\player\PlayerCommandPreprocessEvent};
use pocketmine\event\Listener;


class Main extends PluginBase implements Listener 
{


  public function onEnable() : void 
  {
	$this->getServer()->getPluginManager()->registerEvents($this, $this);
  }


  public function onLoad() : void 
  {
	if(!($this->getConfig()->get('ver')) || $this->getConfig()->get('ver') !== '1.0') {
		$this->getServer()->getLogger()->debug(
			C::RED . 'Invalid Config version - Update plugin or delete the old config file! Disabling plugin.'
		);
		$this->getServer()->getPluginManager()->disablePlugin($this);
	} 
  }
	

  public function onCMD(PlayerCommandPreprocessEvent $event) : void 
  {

    $sender = $event->getPlayer();
    $cmd = $event->getMessage();
    $prefix = $this->getConfig()->get("prefix");
    $msg = $this->getConfig()->get("blocked-message");
  	if(get_class($sender) !== "pocketmine\player\Player") return;
	if($cmd[0] !== "/") return;
	$cmdo = trim($cmd, "/");
	$command = explode(" ",$cmdo)[0];
	if($sender->hasPermission("levellimiter.bypass") 
	|| $sender->hasPermission("levellimiter.bypass." . $sender->getWorld()->getFolderName()) 
	|| $sender->hasPermission("levellimiter.bypass." . $sender->getWorld()->getFolderName() . "." . $command)) return;
	$con = $this->getConfig()->getAll();
	if(isset($con[$command])) {
		if($this->getConfig()->get('mode') === 'blacklist') goto BlacklistMode;
		if(!(is_array($this->getConfig()->get($command)))) goto WhitelistNonArrayException;
		if(!in_array($sender->getWorld()->getFolderName(), $this->getConfig()->get($command))) {
			Cancel:
				$sender->sendMessage($prefix . C::RESET . " " . $msg);
				$event->cancel();
				return;
			}
			BlacklistMode:
			if(!(is_array($this->getConfig()->get($command)))) goto BlacklistNonArrayException;
				if(in_array($sender->getWorld()->getFolderName(), $this->getConfig()->get($command))) goto Cancel;			
				return;
				BlacklistNonArrayException:
				if($sender->getWorld()->getFolderName() === $this->getConfig()->get($command)) goto Cancel;
				return;
				WhitelistNonArrayException:
				if($sender->getWorld()->getFolderName() !== $this->getConfig()->get($command)) goto Cancel;
				return;
		}		
				
  	}

}
