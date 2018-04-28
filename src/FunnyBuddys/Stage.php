<?php

namespace FunnyBuddys;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\utils\TextFormat;
use pocketmine\item\item;
use pocketmine\math\Vector3;

class main extends PluginBase implements Listener {

	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		$this->getLogger()->info("Stage Loaded");

        @mkdir($this->getDataFolder());
        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		
		if($cmd->getName() == "stage" && $sender->hasPermission("stage.youtube")) {
			if(!empty($args[0])) {
				if($args[0] == "help") {
					$sender->sendMessage("§7- §6/stage help §7- §eShows the helppage§7 - ");
					$sender->sendMessage("§7- §6/stage broadcast §7- §eBroadcast a message §7 - ");
					$sender->sendMessage("§7- §6/stage set §7- §eSet the Stage §7 - ");
					$sender->sendMessage("§7- §6/stage tp §7- §eTeleports you to Stage §7 - ");
					}
				if($args[0] == "tp") {
					if($config->get("SG") == null) {
						$sender->sendMessage("§cNo Stage setted");
						}else{
					        $spawn = $config->get("SG");
                            $sender->teleport(new Vector3($spawn[0], $spawn[1], $spawn[2]));
                            $sender->sendMessage("§dWelcome to the Stage!");
                            }
					}else if($args[0] == "broadcast") {
						$n = $sender->getName();
						$this->getServer()->broadcastMessage("§c" . $n . "§6 is by the §cYou§4Tube§7-§cStage!");
						}else if($args[0] == "set") {
							$arena = $sender->getLevel()->getFolderName();
                            $x = $sender->getX();
                            $y = $sender->getY();
                            $z = $sender->getZ();
                            $coords = array($x, $y, $z);

                            $config->set("SG", $coords);
                            $config->save();
                            $sender->sendMessage("§aSetted Stage Succesfully!");
							}
				}else{
					$sender->sendMessage("§cYou don't have the permission to enter the Stage");
					}
			}
		}
	}
