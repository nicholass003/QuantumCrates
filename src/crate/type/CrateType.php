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

namespace nicholass003\quantumcrates\crate\type;

use pocketmine\utils\LegacyEnumShimTrait;

/**
 * TODO: These tags need to be removed once we get rid of LegacyEnumShimTrait (PM6)
 *  These are retained for backwards compatibility only.
 *
 * @method static CrateType BASIC()
 * @method static CrateType COMMON()
 * @method static CrateType UNCOMMON()
 * @method static CrateType RARE()
 * @method static CrateType VERY_RARE()
 * @method static CrateType ULTRA_RARE()
 * @method static CrateType MYTHICAL()
 *
 */

enum CrateType{
	use LegacyEnumShimTrait;

	case BASIC;
	case COMMON;
	case UNCOMMON;
	case RARE;
	case VERY_RARE;
	case ULTRA_RARE;
	case MYTHICAL;

	private static function data(string $name) : array{
		return [$name];
	}

	private function getData() : array{
		return match($this){
			self::BASIC => self::data("Basic"),
			self::COMMON => self::data("Common"),
			self::UNCOMMON => self::data("Uncommon"),
			self::RARE => self::data("Rare"),
			self::VERY_RARE => self::data("Very Rare"),
			self::ULTRA_RARE => self::data("Ultra Rare"),
			self::MYTHICAL => self::data("Mythical")
		};
	}

	public function getName() : string{
		return $this->getData()[0];
	}
}
