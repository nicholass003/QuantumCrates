<?php

declare(strict_types=1);

namespace nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\type\graphic;

use pocketmine\math\Vector3;

interface PositionedInvMenuGraphic extends InvMenuGraphic{

	public function getPosition() : Vector3;
}