<?php

declare(strict_types=1);

namespace nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\type\util\builder;

use nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\type\BlockFixedInvMenuType;
use nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\type\graphic\network\BlockInvMenuGraphicNetworkTranslator;

final class BlockFixedInvMenuTypeBuilder implements InvMenuTypeBuilder{
	use BlockInvMenuTypeBuilderTrait;
	use FixedInvMenuTypeBuilderTrait;
	use GraphicNetworkTranslatableInvMenuTypeBuilderTrait;

	public function __construct(){
		$this->addGraphicNetworkTranslator(BlockInvMenuGraphicNetworkTranslator::instance());
	}

	public function build() : BlockFixedInvMenuType{
		return new BlockFixedInvMenuType($this->getBlock(), $this->getSize(), $this->getGraphicNetworkTranslator());
	}
}