<?php

declare(strict_types=1);

namespace nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\session;

use nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\InvMenu;
use nicholass003\quantumcrates\libs\_5c551721aaac425f\muqsit\invmenu\type\graphic\InvMenuGraphic;

final class InvMenuInfo{

	public function __construct(
		readonly public InvMenu $menu,
		readonly public InvMenuGraphic $graphic,
		readonly public ?string $graphic_name
	){}
}