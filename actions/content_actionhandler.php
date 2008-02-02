<?php

function dbi_readverification_ContentActionHandler( &$module, &$http, &$objectID )
{
    $object = eZContentObject::fetch( $objectID );

    if ( $http->hasPostVariable( 'VerifyAsReadButton' ) )
    {
        include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );
        $user = eZUser::currentUser();

        include_once( 'extension/dbi_readverification/classes/ezcontentobjectreadverification.php' );
        $verification = eZContentObjectReadVerification::fetch( $user->attribute( 'contentobject_id'), $objectID );

        if ( $verification && $verification->attribute( 'read' ) == 0 )
        {
            $verification->verifyAsRead();
        }

        $mainNode = $object->attribute( 'main_node' );
        $module->redirectTo( $mainNode->attribute( 'url_alias' ) );

        return true;
    }
}

?>