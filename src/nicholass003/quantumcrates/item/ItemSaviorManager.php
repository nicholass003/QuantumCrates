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

namespace nicholass003\quantumcrates\item;

use nicholass003\quantumcrates\ManagerTrait;
use nicholass003\quantumcrates\QuantumCrates;
use pocketmine\item\Item;
use pocketmine\nbt\BigEndianNbtSerializer;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\TreeRoot;
use function zlib_decode;
use function zlib_encode;
use const ZLIB_ENCODING_GZIP;

/**
 * Reference Muqsit PlayerVaults
 * @see https://github.com/Muqsit/PlayerVaults
 */

final class ItemSaviorManager{
	use ManagerTrait;

	public const ITEM_SAVIOR = "ItemSavior"; //TAG_Compound

	private BigEndianNbtSerializer $nbtSerializer;

	public function __construct(
		private QuantumCrates $plugin
	){
		$this->nbtSerializer = new BigEndianNbtSerializer();
	}

	public function read(string $data) : Item{
		$items = [];
		$tags = $this->nbtSerializer->read(zlib_decode($data))->mustGetCompoundTag()->getListTag(self::ITEM_SAVIOR);
		/** @var CompoundTag $tag */
		foreach($tags as $tag){
			$items[] = Item::nbtDeserialize($tag);
		}
		return $items[0];
	}

	public function write(Item $item) : string|false{
		$item = $item->nbtSerialize();
		return zlib_encode($this->nbtSerializer->write(new TreeRoot(
			CompoundTag::create()
			->setTag(self::ITEM_SAVIOR, new ListTag([$item], NBT::TAG_Compound))
		)), ZLIB_ENCODING_GZIP);
	}
}