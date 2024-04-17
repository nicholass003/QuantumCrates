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

namespace nicholass003\quantumcrates\animation;

use InvalidArgumentException;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use nicholass003\quantumcrates\crate\Crate;
use pocketmine\block\utils\DyeColor;
use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\player\Player;

class Animation{

    protected InvMenu $menu;

    private int $age;
    /** @var int[] */
    private array $rewardSlot;
    /** @var Item[] */
    private array $cachedReward = [];

    private array $linearData = [];

    private ?Player $opener = null;

    private bool $opened = false;

    public function __construct(
        protected readonly Crate $crate,
        protected readonly array $rewards,
        protected readonly string $invMenuType,
        protected readonly int $countdown,
        protected readonly int $animationType
    ){
        $this->menu = InvMenu::create($invMenuType);
        $this->menu->setName($this->crate->getName());
        $this->menu->setListener(function(InvMenuTransaction $transaction) : InvMenuTransactionResult{
            return $transaction->discard();
        });
        $this->age = $countdown;
        switch($this->invMenuType){
            case InvMenuTypeIds::TYPE_CHEST:
                $this->rewardSlot = [11, 12, 13, 14, 15];
                break;
            case InvMenuTypeIds::TYPE_HOPPER:
                $this->rewardSlot = [3];
                break;
            default:
                throw new InvalidArgumentException("Invalid inventory menu type: " . $this->invMenuType);
        }
    }

    public function getCrate() : Crate{
        return $this->crate;
    }

    public function getRewardSlot() : array{
        return $this->rewardSlot;
    }

    public function setRewardSlot(array $rewardSlot) : void{
        $this->rewardSlot = $rewardSlot;
    }

    public function getOpener() : ?Player{
        return $this->opener;
    }

    public function setOpener(Player $opener) : Animation{
        $this->opener = $opener;
        return $this;
    }

    public function isOpened() : bool{
        return $this->opened !== false;
    }

    public function setOpened(bool $value = true) : Animation{
        $this->opened = $value;
        return $this;
    }

    public function getAge() : int{
        return $this->age;
    }

    public function getMenu() : InvMenu{
        return $this->menu;
    }

    public function tick() : void{
        --$this->age;
        if($this->opener instanceof Player){
            if($this->opened === true){
                $this->menu->send($this->opener);
                $this->setOpened(false);
            }
        }
        $inventory = $this->menu->getInventory();
        if($this->age >= 0){
            /** @var Item $random */
            $random = $this->rewards[array_rand($this->rewards)];
            $this->cachedReward[] = $random;
            $colors = DyeColor::getAll();
            for($i = 0; $i < $inventory->getSize(); $i++){
                if(!in_array($i, $this->rewardSlot)){
                    $inventory->setItem($i, VanillaBlocks::STAINED_GLASS_PANE()->setColor($colors[array_rand($colors)])->asItem());
                }
            }
            krsort($this->cachedReward);
            $slotIndex = 0;
            foreach($this->cachedReward as $reward){
                $index = $this->rewardSlot[$slotIndex % count($this->rewardSlot)];
                $this->linearData[$index] = $reward;
                $slotIndex++;
            }
            switch($this->animationType){
                case AnimationType::LINEAR:
                    $this->linear($inventory);
                    break;
                case AnimationType::SPIRAL:
                    // TODO: Spiral Animations
                    break;
            }
        }
    }

    private function linear(Inventory $inventory) : void{
        /** @var Item $reward */
        foreach($this->linearData as $slot => $reward){
            $inventory->setItem($slot, $reward);
        }
    }
}