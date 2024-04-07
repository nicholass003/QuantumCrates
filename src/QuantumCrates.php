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

namespace nicholass003\quantumcrates;

use nicholass003\quantumcrates\command\QuantumCratesCommand;
use nicholass003\quantumcrates\crate\CrateManager;
use nicholass003\quantumcrates\probability\tests\ProbabilityTestExecute;
use nicholass003\quantumcrates\reward\RewardManager;
use nicholass003\quantumcrates\task\UpdateCheckerTask;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use function class_exists;

class QuantumCrates extends PluginBase{
	use SingletonTrait;

	public const PREFIX = "§d[§eQuantumCrates§d]§r ";

	private const IS_DEVELOPMENT_BUILD = true;

	protected function onLoad() : void{
		$this->saveDefaultConfig();

		if(!CrateManager::isRegistered()){
			$crateManager = new CrateManager($this);
			$crateManager->init();
		}

		if(!RewardManager::isRegistered()){
			$rewardManager = new RewardManager($this);
			$rewardManager->init();
		}
	}

	protected function onEnable() : void{
		if(self::IS_DEVELOPMENT_BUILD === true){
			if(class_exists(ProbabilityTestExecute::class)){
				ProbabilityTestExecute::execute();
			}
		}

		$this->registerCommands();

		$this->getServer()->getAsyncPool()->submitTask(new UpdateCheckerTask($this));
	}

	private function registerCommands() : void{
		$cmdMap = $this->getServer()->getCommandMap();
		$cmdMap->register("quantumcrates", new QuantumCratesCommand($this));
	}
}
