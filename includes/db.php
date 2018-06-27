<?php

define("URL", "127.0.0.1");
define("DATABASE", "cms");
define("USERNAME", "root");
define("PASSWORD", "");


/*$GLOBALS['connection'] = mysqli_connect(URL, USERNAME, PASSWORD, DATABASE) or die("Connection failed");*/
$connection = mysqli_connect(URL, USERNAME, PASSWORD, DATABASE) or die("Connection failed");



?>