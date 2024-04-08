<?php

/*
 * Copyright (c) 2024 - present nicholass003
 *        _      _           _                ___   ___ ____
 *       (_)    | |         | |              / _ \ / _ \___ \
 *  _ __  _  ___| |__   ___ | | __ _ ___ ___| | | | | | |__) |
 * | '_ \| |/ __| '_ \ / _ \| |/ _` / __/ __| | | | | | |__ <
 * | | | | | (__| | | | (_) | | (_| \__ \__ \ |_| | |_| |__) |
 * |_| |_|_|\___|_| |_|\___/|_|\__,_|___/___/\___/ \___/____/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  nicholass003
 * @link    https://github.com/nicholass003/
 *
 *
 */

declare(strict_types=1);

namespace nicholass003\quantumcrates\command;

use nicholass003\quantumcrates\crate\CrateManager;
use nicholass003\quantumcrates\crate\utils\CrateItemUtils;
use nicholass003\quantumcrates\QuantumCrates;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function strtolower;

class QuantumCratesCommand extends QuantumCratesBaseCommand{

	public function __construct(
		private QuantumCrates $plugin
	){
		parent::__construct($plugin, "quantumcrates", "QuantumCrates Command", "Usage: /quantumcrates [options]", ["qcrate", "qcrates"]);
		$this->setPermission("quantumcrates.command");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
		if($sender instanceof Player){
			if(isset($args[0])){
				switch(strtolower($args[0])){
					case "get":
						if(!$sender->hasPermission("quantumcrates.command.get")){
							$sender->sendMessage(QuantumCrates::PREFIX . TextFormat::RED . "You do not have permission to use this command.");
							return;
						}
						if(isset($args[1])){
							$crate = CrateManager::getInstance()->getCrateById($args[1]);
							if($crate === null){
								$sender->sendMessage(QuantumCrates::PREFIX . TextFormat::RED . "No crates were found with id: {$args[1]}.");
								return;
							}
							$sender->getInventory()->addItem(CrateItemUtils::write($crate));
						}
						break;
					default:
						$sender->sendMessage(TextFormat::RED . "Usage: /quantumcrates [options]");
				}
			}else{
				$sender->sendMessage(TextFormat::RED . "Usage: /quantumcrates [options]");
			}
		}
	}
}
