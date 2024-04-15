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

namespace nicholass003\quantumcrates\task;

use nicholass003\quantumcrates\crate\Crate;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\Position;
use pocketmine\world\sound\NoteInstrument;
use pocketmine\world\sound\NoteSound;
use pocketmine\world\sound\XpLevelUpSound;
use pocketmine\world\World;

class OpenCrateTask extends Task{

    public function __construct(
        private Crate $crate,
        private Player $opener,
        private Item $reward
    ){}

    public function onRun() : void{
        $animation = $this->crate->getAnimation();
        if($animation !== null){
            $animation->tick();
            $pos = $this->opener->getPosition();
            $world = $pos->getWorld();
            if($this->opener->getCurrentWindow() !== $animation->getMenu()->getInventory()){
                $this->finishAnimation($world, $pos);
                $this->getHandler()->cancel();
            }
            $world->addSound($pos, new NoteSound(NoteInstrument::GUITAR(), 5));
            if($animation->getAge() < 0){
                $this->finishAnimation($world, $pos);
                $this->opener->removeCurrentWindow();
                $this->getHandler()->cancel();
            }
        }
    }

    private function finishAnimation(World $world, Position $pos) : void{
        $this->opener->getInventory()->addItem($this->reward);
        $this->crate->sendBroadcastMessage($this->opener->getName() . " just got " . $this->reward->getName() . " x" . $this->reward->getCount() . " from " . $this->crate->getName());
        $world->addSound($pos, new XpLevelUpSound(10));
    }
}