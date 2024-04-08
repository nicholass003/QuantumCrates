<?php

declare(strict_types=1);

namespace nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\type\graphic\network;

use nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\session\InvMenuInfo;
use nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\session\PlayerSession;
use pocketmine\network\mcpe\protocol\ContainerOpenPacket;

final class MultiInvMenuGraphicNetworkTranslator implements InvMenuGraphicNetworkTranslator{

	/**
	 * @param InvMenuGraphicNetworkTranslator[] $translators
	 */
	public function __construct(
		readonly private array $translators
	){}

	public function translate(PlayerSession $session, InvMenuInfo $current, ContainerOpenPacket $packet) : void{
		foreach($this->translators as $translator){
			$translator->translate($session, $current, $packet);
		}
	}
}