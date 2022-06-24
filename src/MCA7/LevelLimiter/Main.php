<?php

declare(strict_types=1);

namespace MCA7\LevelLimiter;
// By MCA7#1245

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;
use pocketmine\{event\player\PlayerCommandPreprocessEvent, event\Player};
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener {

  public function onEnable():void {

    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
	

  public function onCMD(PlayerCommandPreprocessEvent $event):void {
    $sender = $event->getPlayer();
    $cmd = $event->getMessage();
    $prefix = $this->getConfig()->get("prefix");
    $msg = $this->getConfig()->get("blocked-message");
  	if(get_class($sender) == "pocketmine\player\Player") {
		if($cmd[0] == "/") {
			if (!$sender->hasPermission("levellimiter.bypass")) {
				if (!$sender->hasPermission("levellimiter.bypass." . $sender->getWorld()->getFolderName())) {
					$cmdo = trim($cmd, "/");
					if (!$sender->hasPermission("levellimiter.bypass." . $sender->getWorld()->getFolderName() . "." . explode(" ",$cmdo)[0])) {
						$con = $this->getConfig()->getAll();
						if (isset($con[explode(" ",$cmdo)[0]])) {
							if (!in_array($sender->getWorld()->getFolderName(), $this->getConfig()->get( explode(" ",$cmdo)[0] ))) {
								$sender->sendMessage($prefix . C::RESET . " " . $msg);
								$event->isCancelled(true);
								return;
							}
						}
					}
			  	}
			}
		}
	}
  }
}
