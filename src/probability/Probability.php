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

namespace nicholass003\quantumcrates\probability;

use Generator;
use nicholass003\quantumcrates\reward\BasicReward;
use nicholass003\quantumcrates\reward\Reward;
use nicholass003\quantumcrates\reward\RewardManager;

use function array_sum;
use function mt_rand;

final class Probability{

	public function __construct(
		private array $objects,
		private BasicReward $basicReward
	){}

	public function calculate() : Reward{
		$total = (int) array_sum($this->objects);
		$rand = mt_rand(1, $total);
		$partialSum = 0;
		$rewards = RewardManager::getInstance()->getReward($this->basicReward->getId());
		foreach($this->objects as $id => $chance){
			$partialSum += $chance;
			if($rand <= $chance){
				if($chance === 100){
					continue;
				}
				$rewards = RewardManager::getInstance()->getReward($id);
			}
		}
		return $rewards;
	}

	public function generateResults(int $count) : Generator{
		for($i = 0; $i < $count; $i++){
			yield $this->calculate();
		}
	}
}
