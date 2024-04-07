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

use nicholass003\quantumcrates\crate\type\CrateType;
use function str_replace;
use function strtolower;

final class CrateColorNameUtils{

    private static array $colors = [];

	public static function defaultColor(CrateType $crateType) : string{
		return match($crateType){
			CrateType::BASIC() => "§f",
			CrateType::COMMON() => "§7",
			CrateType::UNCOMMON() => "S3",
			CrateType::RARE() => "§2",
			CrateType::VERY_RARE() => "§b",
			CrateType::ULTRA_RARE() => "§c",
			CrateType::MYTHICAL() => "§d"
		};
	}

    public static function setCustomColor(array $customColors) : void{
        self::$colors = $customColors;
    }

	public static function customColor(CrateType $crateType) : string{
        return self::$colors[self::parseName($crateType->getName())] ?? self::defaultColor($crateType);
	}

	private static function parseName(string $name) : string{
		return strtolower(str_replace(" ", "_", $name));
	}
}
