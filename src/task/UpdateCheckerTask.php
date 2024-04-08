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

use nicholass003\quantumcrates\QuantumCrates;
use pocketmine\plugin\ApiVersion;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\Internet;
use function json_decode;
use function version_compare;

/**
 * Reference DaPigGuy libPiggyUpdateChecker
 * @see https://github.com/DaPigGuy/libPiggyUpdateChecker
 */

final class UpdateCheckerTask extends AsyncTask{

	public function __construct(
		private string $name,
		private string $version
	){}

	public function onRun() : void{
		$result = Internet::getURL("https://poggit.pmmp.io/releases.min.json?name=" . $this->name, 10, [], $err);
		$this->setResult([$result?->getBody(), $err]);
	}

	public function onCompletion() : void{
		$server = Server::getInstance();
		$logger = $server->getLogger();
		[$body, $err] = $this->getResult();
		if($err){
			$logger->warning("UpdateChecker failed.");
			$logger->debug($err);
		}else{
			$versions = json_decode($body, true);
			if($versions){
				foreach($versions as $version){
					if(version_compare($this->version, $version["version"]) === -1){
						if(ApiVersion::isCompatible($server->getApiVersion(), $version["api"][0])){
							$logger->notice($this->name . " v" . $version["version"] . " is available for download at " . $version["artifact_url"] . "/" . $this->name . ".phar");
							break;
						}
					}
				}
			}
		}
	}
}
