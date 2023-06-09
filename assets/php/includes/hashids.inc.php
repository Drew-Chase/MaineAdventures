<?php
require_once "values.inc.php";

/* Including the Hashids library. */
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/libraries/hashids/src/Math/MathInterface.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/libraries/hashids/src/Math/Bc.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/libraries/hashids/src/HashidsInterface.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/libraries/hashids/src/Hashids.php";

/* Importing the Hashids class from the Hashids namespace. */

use Hashids\Hashids;

/* Creating a new instance of the HashIds class. */

$hashids = new HashIds($salt, 12);
