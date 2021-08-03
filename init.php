<?php

include 'connect.php';


$tmbl = 'inc/tmbl/';
$func = 'inc/func/';


include $func . 'function.php';
include $tmbl . 'header.php';
if (!isset($nonav)) {
    include $tmbl . 'nav.php';
}