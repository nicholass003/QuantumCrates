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

namespace nicholass003\quantumcrates\crate;

use nicholass003\quantumcrates\crate\type\CrateItemType;
use nicholass003\quantumcrates\crate\type\CrateType;
use nicholass003\quantumcrates\reward\Reward;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;

class Crate{

	/** @var Reward[] */
	private array $rewards = [];

	private string $originalName;

	private Item $itemType;

	public function __construct(
		private string $id,
		private string $name,
		private CrateType $crateType,
		private string $crateItemType
	){
		$this->originalName = $crateType->getName() . " ({$id})";
		$this->itemType = $this->parseItemType($crateItemType);
	}

	public function getName() : string{
		return $this->name;	
	}

	public function setName(string $name) : Crate{
		$this->name = $name;
		return $this;
	}

	public function getOriginalName() : string{
		return $this->originalName;
	}

	public function geCrateType() : CrateType{
		return $this->crateType;
	}

	public function getReward() : array{
		return $this->rewards;
	}

	public function setRewards(array $rewards) : Crate{
		$this->rewards = $rewards;
		return $this;
	}

	public function getItemType() : Item{
		return $this->itemType;
	}

	private function parseItemType(string $crateItemType) : Item{
		return match($crateItemType){
			CrateItemType::CHEST => VanillaBlocks::CHEST()->asItem(),
			CrateItemType::ENDER_CHEST => VanillaBlocks::ENDER_CHEST()->asItem(),
			default => throw new \InvalidArgumentException("Invalid crate item type")
		};
	}
}
