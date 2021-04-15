<?php

declare(strict_types=1);

namespace MCA7\LevelLimiter;
// By MCA7#1245

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;
use pocketmine\{event\server\CommandEvent, Player};
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener {

  public function onEnable() {

    @mkdir($this->getDataFolder());
    $this->saveDefaultConfig();
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  public function onCMD(CommandEvent $event) {
    $sender = $event->getSender();
    $cmd = $event->getCommand();
  	if($sender instanceof Player) {
		if (!$sender->hasPermission("levellimiter.bypass")) {
			if (!$sender->hasPermission("levellimiter.bypass." . $sender->getLevel()->getName())) {
				if (!$sender->hasPermission("levellimiter.bypass." . $sender->getLevel()->getName() . "." . $cmd)) {
					$con = $this->getConfig()->getAll();
					if (isset($con[$cmd])) {
						if (!in_array($sender->getLevel()->getName(), $this->getConfig()->get($cmd))) {
							$sender->sendMessage(C::DARK_RED . C::BOLD . "LevelLimiter :" . C::RESET . C::RED . " This command is disabled on this world!");
							$event->setCancelled();
							return true;
						}
					}
				}
			  }
			}
		}
	}
}
