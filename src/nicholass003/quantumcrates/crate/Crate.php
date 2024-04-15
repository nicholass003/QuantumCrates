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

use nicholass003\quantumcrates\animation\Animation;
use nicholass003\quantumcrates\crate\type\CrateItemType;
use nicholass003\quantumcrates\crate\type\CrateType;
use nicholass003\quantumcrates\probability\Probability;
use nicholass003\quantumcrates\probability\ProbabilityCalculateType;
use nicholass003\quantumcrates\QuantumCrates;
use nicholass003\quantumcrates\reward\BasicReward;
use nicholass003\quantumcrates\reward\Reward;
use nicholass003\quantumcrates\reward\RewardManager;
use nicholass003\quantumcrates\task\OpenCrateTask;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\Server;

class Crate{

	/** @var Reward[] */
	private array $rewards = [];

	private string $originalName;

	private Item $itemType;
	private ?BasicReward $basicReward = null;

	private ?Animation $animation = null;

	public function __construct(
		private string $id,
		private string $name,
		private CrateType $crateType,
		private string $crateItemType
	){
		$this->originalName = $crateType->getName() . " ({$id})";
		$this->itemType = $this->parseItemType($crateItemType)->setCustomName($this->name);
	}

	public function getId() : string{
		return $this->id;
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

	public function getRewards() : array{
		return $this->rewards;
	}

	public function setRewards(array $rewards) : Crate{
		$this->rewards = $rewards;
		foreach($this->rewards as $reward){
			RewardManager::getInstance()->addReward($reward->getId(), $reward);
		}
		return $this;
	}

	public function getItemType() : Item{
		return $this->itemType;
	}

	public function getBasicReward() : BasicReward{
		return $this->basicReward;
	}

	public function setBasicReward(BasicReward $basicReward) : Crate{
		$this->basicReward = $basicReward;
		return $this;
	}

	public function getAnimation() : ?Animation{
		return $this->animation;
	}

	public function setAnimation(Animation $animation) : Crate{
		$this->animation = $animation;
		return $this;
	}

	public function sendBroadcastMessage(string $message) : void{
		Server::getInstance()->broadcastMessage($message);
	}

	public function openCrate(Player $player, int $count = 1) : void{
		$probabilities = [];
		foreach($this->rewards as $reward){
			$probabilities[$reward->getId()] = $reward->getChance();
		}
		$probabilityTier = new Probability($probabilities, ProbabilityCalculateType::REWARD_TIER, $this->basicReward);
		$resultsTier = $probabilityTier->generateResults($count);
		foreach($resultsTier as $result){
			if($result instanceof Reward){
				$probabilityItems = new Probability($result->getItems(), ProbabilityCalculateType::REWARD_ITEMS, $this->basicReward);
				$resultsItems = $probabilityItems->generateResults($count);
				/** @var Item $item */
				foreach($resultsItems as $item){
					if($this->animation === null){
						$player->getInventory()->addItem($item);
						$this->sendBroadcastMessage($player->getName() . " just got " . $item->getName() . " x" . $item->getCount() . " from " . $this->getName());
					}else{
						$this->animation->setOpener($player);
						$this->animation->setOpened();
						QuantumCrates::getInstance()->getScheduler()->scheduleRepeatingTask(new OpenCrateTask($this, $player, $item), 20);
					}
				}
			}
		}
	}

	private function parseItemType(string $crateItemType) : Item{
		return match($crateItemType){
			CrateItemType::CHEST => VanillaBlocks::CHEST()->asItem(),
			CrateItemType::ENDER_CHEST => VanillaBlocks::ENDER_CHEST()->asItem(),
			default => throw new \InvalidArgumentException("Invalid crate item type")
		};
	}
}