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

use nicholass003\quantumcrates\probability\tests\ProbabilityTestExecute;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use function class_exists;

class QuantumCrates extends PluginBase{
	use SingletonTrait;

	private const IS_DEVELOPMENT_BUILD = true;
	private const BASE_VERSION = "1.0.0";

	protected function onLoad() : void{
		$this->saveDefaultConfig();
	}

	protected function onEnable() : void{
		if(self::IS_DEVELOPMENT_BUILD === true){
			if(class_exists(ProbabilityTestExecute::class)){
				ProbabilityTestExecute::execute();
			}
		}
	}
}
