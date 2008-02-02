<?php

$Module =& $Params['Module'];
$UserID = $Params['user_id'];

if ( !$UserID )
{
    return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}

$ObjectID = $Params['object_id'];

include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );
$user = eZUser::fetch( $UserID );

if ( !$user )
{
     return $Module->handleError( EZ_ERROR_KERNEL_NOT_AVAILABLE, 'kernel' );
}

$userObject = $user->attribute( 'contentobject' );

include_once( 'kernel/common/template.php' );
$tpl =& templateInit();


$tpl->setVariable( 'user', $user );

if ( $ObjectID )
{
    $object = eZContentObject::fetch( $ObjectID );

    if ( !$object )
    {
        return $Module->handleError( EZ_ERROR_KERNEL_NOT_AVAILABLE, 'kernel' );
    }

    include_once( 'extension/dbi_readverification/classes/ezcontentobjectversionreadverification.php' );
    $versionInfo = eZContentObjectVersionReadVerification::fetchContentObjectVersionInfo( $ObjectID, $UserID );

    $tpl->setVariable( 'object', $object );
    $tpl->setVariable( 'version_info', $versionInfo );

    $Result = array();
    $Result['content'] = $tpl->fetch( 'design:readverification/user_object.tpl' );
    $Result['left_menu'] = 'design:parts/readverification/menu.tpl';
    $Result['path'] = array(
        array( 'url' => false, 'text' => 'Read verification' ),
        array( 'url' => false, 'text' => 'By user' ),
        array( 'url' => '/readverification/user/' . $UserID, 'text' => $userObject->attribute( 'name' ) )
    );
}
else
{
    include_once( 'extension/dbi_readverification/classes/ezcontentobjectreadverification.php' );
    $readObjects = eZContentObjectReadVerification::fetchReadContentObjectsByUser( $UserID );
    $unreadObjects = eZContentObjectReadVerification::fetchUnreadContentObjectsByUser( $UserID );

    $tpl->setVariable( 'read_objects', $readObjects );
    $tpl->setVariable( 'unread_objects', $unreadObjects );

    $Result = array();
    $Result['content'] = $tpl->fetch( 'design:readverification/user.tpl' );
    $Result['left_menu'] = 'design:parts/readverification/menu.tpl';
    $Result['path'] = array(
        array( 'url' => false, 'text' => 'Read verification' ),
        array( 'url' => false, 'text' => 'By user' ),
        array( 'url' => false, 'text' => $userObject->attribute( 'name' ) )
    );
}

?>