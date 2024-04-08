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

namespace nicholass003\quantumcrates\probability\tests;

use nicholass003\quantumcrates\probability\Probability;
use nicholass003\quantumcrates\probability\ProbabilityCalculateType;
use nicholass003\quantumcrates\reward\BasicReward;
use nicholass003\quantumcrates\reward\CommonReward;
use nicholass003\quantumcrates\reward\Reward;
use nicholass003\quantumcrates\reward\UncommonReward;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use function var_dump;

class ProbabilityTest{

	public function testProbability() : void{
		$basic = new BasicReward([VanillaItems::ARROW(), VanillaBlocks::DIRT()->asItem()], "basicTest", VanillaItems::APPLE());
		$common = new CommonReward([VanillaItems::STEAK(), VanillaItems::GOLDEN_APPLE()], "commonTest");
		$uncommon = new UncommonReward([VanillaItems::APPLE(), VanillaItems::WOODEN_AXE()], "uncommonTest");
		$probabilities = [
			$common->getId() => $common->getChance(),
			$uncommon->getId() => $uncommon->getChance()
		];
		$probability = new Probability($probabilities, ProbabilityCalculateType::REWARD_TIER, $basic);
		$results = $probability->generateResults(10);
		/** @var Reward $result */
		foreach($results as $result){
			var_dump($result);
		}
	}
}