<?php

include_once( 'kernel/common/template.php' );
$tpl =& templateInit();

include_once( 'extension/dbi_readverification/classes/ezcontentobjectreadverification.php' );
$users = eZContentObjectReadVerification::fetchUsers();

$tpl->setVariable( 'users', $users );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:readverification/user_list.tpl' );
$Result['left_menu'] = 'design:parts/readverification/menu.tpl';
$Result['path'] = array(
    array( 'url' => false, 'text' => 'Read verification' ),
    array( 'url' => false, 'text' => 'User list' ) );
?>