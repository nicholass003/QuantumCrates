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

namespace nicholass003\quantumcrates\reward;

use nicholass003\quantumcrates\ManagerTrait;
use nicholass003\quantumcrates\QuantumCrates;
use nicholass003\quantumcrates\reward\exception\RewardException;

final class RewardManager{
	use ManagerTrait;

	private array $rewards = [];

	public function __construct(
		private QuantumCrates $plugin
	){}

	public function addReward(string $id, Reward $reward) : void{
		if(!isset($this->rewards[$id])){
			$this->rewards[$id] = $reward;
		}
	}

	public function removeReward(string $id) : void{
		if(isset($this->rewards[$id])){
			unset($this->rewards[$id]);
		}
	}

	public function getRewards() : array{
		return $this->rewards;
	}

	public function getReward(string $id) : Reward{
		return $this->rewards[$id] ?? throw new RewardException("Missing reward from id: {$id}");
	}
}