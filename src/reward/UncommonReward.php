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

use nicholass003\quantumcrates\reward\chance\RewardDefaultChance;
use nicholass003\quantumcrates\reward\tier\RewardTier;

class UncommonReward implements Reward{

	public function __construct(
		private array $items,
		private string $id
	){}

	public function getId() : string{
		return $this->id;
	}

	public function getTier() : int{
		return RewardTier::UNCOMMON;
	}

	public function getItems() : array{
		return $this->items;
	}

	public function getChance() : int{
		return RewardDefaultChance::getChance($this);
	}
}
