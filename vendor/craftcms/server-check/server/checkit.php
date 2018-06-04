<?php

// Turn it all on.
error_reporting(E_ALL | E_STRICT);
@ini_set('display_errors', '1');

require_once(__DIR__.'/requirements/RequirementsChecker.php');

$checker = new RequirementsChecker();
$checker->checkCraft()->render();
