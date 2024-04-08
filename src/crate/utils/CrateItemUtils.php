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

namespace nicholass003\quantumcrates\crate\utils;

use nicholass003\quantumcrates\crate\Crate;
use nicholass003\quantumcrates\crate\CrateManager;
use pocketmine\item\Item;
use pocketmine\nbt\tag\StringTag;

final class CrateItemUtils{

	public const CRATE_ITEM = "CrateItem";

	public static function write(Crate $crate) : Item{
		$item = $crate->getItemType();
		$item->getNamedTag()->setString(self::CRATE_ITEM, $crate->getId());
		return $item;
	}

	public static function read(Item $item) : ?Crate{
		$crate = null;
        $tag = $item->getNamedTag()->getTag(self::CRATE_ITEM);
        if($tag !== null && $tag instanceof StringTag){
            $crate = CrateManager::getInstance()->getCrateById($tag->getValue());
        }
		return $crate;
	}
}
