<?php

declare(strict_types=1);

namespace nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\inventory;

use pocketmine\inventory\Inventory;
use pocketmine\inventory\InventoryListener;
use pocketmine\item\Item;

final class SharedInventorySynchronizer implements InventoryListener{

	public function __construct(
		readonly private Inventory $inventory
	){}

	public function getSynchronizingInventory() : Inventory{
		return $this->inventory;
	}

	public function onContentChange(Inventory $inventory, array $old_contents) : void{
		$this->inventory->setContents($inventory->getContents());
	}

	public function onSlotChange(Inventory $inventory, int $slot, Item $old_item) : void{
		$this->inventory->setItem($slot, $inventory->getItem($slot));
	}
}