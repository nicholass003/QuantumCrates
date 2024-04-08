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

use nicholass003\quantumcrates\crate\utils\CrateTypeUtils;
use nicholass003\quantumcrates\item\ItemSaviorManager;
use nicholass003\quantumcrates\ManagerTrait;
use nicholass003\quantumcrates\QuantumCrates;
use nicholass003\quantumcrates\reward\BasicReward;
use nicholass003\quantumcrates\reward\CommonReward;
use nicholass003\quantumcrates\reward\UncommonReward;
use pocketmine\item\StringToItemParser;
use pocketmine\utils\Config;

final class CrateManager{
	use ManagerTrait;

	private array $crates = [];

	public function __construct(
		private QuantumCrates $plugin
	){}

	public function loadFromConfig(Config $data) : void{
		foreach($data->getAll() as $crate => $crateData){
			$crate = new Crate($crateData["id"], $crateData["name"], CrateTypeUtils::getCrateTypeFromString($crateData["crate-type"]), $crateData["item-type"]);
			$crate->setRewards($this->loadRewardsFromConfig($crate, [
				"default" => $crateData["rewards"]["default"] ?? null,
				"basic" => $crateData["rewards"]["basic"] ?? null,
				"common" => $crateData["rewards"]["common"] ?? null,
				"uncommon" => $crateData["rewards"]["uncommon"] ?? null,
				"rare" => $crateData["rewards"]["rare"] ?? null,
				"very_rare" => $crateData["rewards"]["very_rare"] ?? null,
				"ultra_rare" => $crateData["rewards"]["ultra_rare"] ?? null,
				"mythical" => $crateData["rewards"]["mythical"] ?? null
			]));
			$this->addCrate($crate->getId(), $crate);
			var_dump($crate->getRewards());
		}
	}

	public function addCrate(string $id, Crate $crate) : CrateManager{
		if(!isset($this->crates[$id])){
			$this->crates[$id] = $crate;
		}
		return $this;
	}
	
	public function getCrates() : array{
		return $this->crates;
	}

	public function getCrateById(string $id) : ?Crate{
		return $this->crates[$id] ?? null;
	}

	private function loadRewardsFromConfig(Crate $crate, array $data) : array{
		$rewards = [];
		foreach(["basic", "common", "uncommon", "rare", "very_rare", "ultra_rare", "mythical"] as $reward){
			if($data[$reward] !== null){
				switch($reward){
					case "basic":
						$parts = explode(":", $data["default"]);
						$default = StringToItemParser::getInstance()->parse($parts[0]);
						if($default !== null){
							$default->setCount((int) ($parts[1] ?? 1));
						}
						$crate->setBasicReward(new BasicReward($this->parseItemData($data["basic"]), $crate->getId(), $default));
						break;
					case "common":
						$rewards[] = new CommonReward($this->parseItemData($data["common"]), $crate->getId());
						break;
					case "uncommon":
						$rewards[] = new UncommonReward($this->parseItemData($data["uncommon"]), $crate->getId());
						break;
					case "rare":
						break;
					case "very_rare":
						break;
					case "ultra_rare":
						break;
					case "mythical":
						break;
				}
			}
		}
		return $rewards;
	}

	private function parseItemData(array $data) : array{
		$results = [];
		foreach($data as $value){
			$parts = explode(":", $value);
			$item = StringToItemParser::getInstance()->parse($parts[0]);
			if($item !== null){
				$item->setCount((int) ($parts[1] ?? 1));
				$itemNBT = ItemSaviorManager::getInstance()->write($item);
				if($itemNBT !== false){
					$results[$itemNBT] = (int) ($parts[2] ?? 50);
				}
			}
		}
		return $results;
	}
}
