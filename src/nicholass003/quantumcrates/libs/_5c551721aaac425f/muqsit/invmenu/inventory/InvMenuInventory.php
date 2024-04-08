<?php

declare(strict_types=1);

namespace nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\inventory;

use pocketmine\block\inventory\BlockInventory;
use pocketmine\inventory\SimpleInventory;
use pocketmine\world\Position;

final class InvMenuInventory extends SimpleInventory implements BlockInventory{

	private Position $holder;

	public function __construct(int $size){
		parent::__construct($size);
		$this->holder = new Position(0, 0, 0, null);
	}

	public function getHolder() : Position{
		return $this->holder;
	}
}