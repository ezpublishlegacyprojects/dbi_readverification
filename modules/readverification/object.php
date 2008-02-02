<?php

$Module =& $Params['Module'];
$ObjectID = $Params['object_id'];

if ( !$ObjectID )
{
     return $Module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}

$object = eZContentObject::fetch( $ObjectID );

if ( !$object )
{
    return $Module->handleError( EZ_ERROR_KERNEL_NOT_AVAILABLE, 'kernel' );
}

include_once( 'extension/dbi_readverification/classes/ezcontentobjectreadverification.php' );
$unreadUsers = eZContentObjectReadVerification::fetchUsersByUnreadContentObject( $ObjectID );
$readUsers = eZContentObjectReadVerification::fetchUsersByReadContentObject( $ObjectID );

include_once( 'kernel/common/template.php' );
$tpl =& templateInit();

$tpl->setVariable( 'object', $object );
$tpl->setVariable( 'unread_users', $unreadUsers );
$tpl->setVariable( 'read_users', $readUsers );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:readverification/object.tpl' );
$Result['left_menu'] = 'design:parts/readverification/menu.tpl';
$Result['path'] = array(
    array( 'url' => false, 'text' => 'Read verification' ),
    array( 'url' => false, 'text' => 'By object' ),
    array( 'url' => false, 'text' => $object->attribute( 'name' ) )
);

?>