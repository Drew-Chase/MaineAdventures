<?php
header("Content-Type: application/json");
require_once "values.inc.php";
/* Including the Hashids library. */
require_once realpath(getcwd() . "/../libraries/hashids/src/Math/MathInterface.php");
require_once realpath(getcwd() . "/../libraries/hashids/src/Math/Bc.php");
require_once realpath(getcwd() . "/../libraries/hashids/src/HashidsInterface.php");
require_once realpath(getcwd() . "/../libraries/hashids/src/Hashids.php");

/* Importing the Hashids class from the Hashids namespace. */

use Hashids\Hashids;

/* Creating a new instance of the Hashids class. The first parameter is the salt, which is used to
generate the hash. The second parameter is the minimum length of the hash. */

$hashids = new HashIds($salt, 12);

/* Checking if the `id` parameter is set in the URL. If it is, it will return a JSON object with the
key `key` and the value of the `id` parameter encoded with the Hashids library. */
if (isset($_GET["id"])) {
    die(json_encode(["key" => $hashids->encode($_GET["id"])]));
}

/* This is the same as the previous `if` statement, but it checks if the `key` parameter is set in
the URL. If it is, it will return a JSON object with the key `id` and the value of the `key`
parameter decoded with the Hashids library. */
if (isset($_GET["key"])) {
    die(json_encode(["id" => $hashids->decode($_GET["key"])[0]]));
}
