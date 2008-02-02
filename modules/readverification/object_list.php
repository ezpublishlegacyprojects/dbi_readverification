<?php

include_once( 'kernel/common/template.php' );
$tpl =& templateInit();

include_once( 'lib/ezutils/classes/ezhttptool.php' );
$http =& eZHTTPTool::instance();

$sorts = false;
if ( $http->hasPostVariable( 'SortButton' ) && $http->hasPostVariable( 'SortField' ) && $http->hasPostVariable( 'SortOrder' ) )
{
    $sortField = $http->postVariable( 'SortField' );
    $sortOrder = $http->postVariable( 'SortOrder' );

    $tpl->setVariable( 'sortField', $sortField );
    $tpl->setVariable( 'sortOrder', $sortOrder );

    $sorts = array( $sortField => $sortOrder );
}

include_once( 'extension/dbi_readverification/classes/ezcontentobjectreadverification.php' );
$objects = eZContentObjectReadVerification::fetchContentObjects( $sorts );

$tpl->setVariable( 'objects', $objects );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:readverification/object_list.tpl' );
$Result['left_menu'] = 'design:parts/readverification/menu.tpl';
$Result['path'] = array(
    array( 'url' => false, 'text' => 'Read verification' ),
    array( 'url' => false, 'text' => 'Object list' ) );
?>