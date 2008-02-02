<?php

$Module = array( 'name' => 'ReadVerification', 'variable_params' => false, 'ui_component_match' => 'module' );
$ViewList = array();

$ViewList['user_list'] = array(
    'functions' => array( 'user_info' ),
    'default_navigation_part' => 'readverification',
    'script' => 'user_list.php',
    'params' => array()
);

$ViewList['user'] = array(
    'functions' => array( 'user_info' ),
    'default_navigation_part' => 'readverification',
    'script' => 'user.php',
    'params' => array( 'user_id', 'object_id' )
);

$ViewList['object_list'] = array(
    'functions' => array( 'object_info' ),
    'default_navigation_part' => 'readverification',
    'script' => 'object_list.php',
    'params' => array()
);

$ViewList['object'] = array(
    'functions' => array( 'object_info' ),
    'default_navigation_part' => 'readverification',
    'script' => 'object.php',
    'params' => array( 'object_id' )
);

$FunctionList = array();
$FunctionList['user_info'] = array();
$FunctionList['object_info'] = array();

?>