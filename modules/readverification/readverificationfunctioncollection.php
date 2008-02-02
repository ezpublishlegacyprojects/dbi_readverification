<?php

include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );
include_once( 'extension/dbi_readverification/classes/ezcontentobjectreadverification.php' );

class ReadVerificationFunctionCollection
{
    function status( $objectID )
    {
        $user = eZUser::currentUser();
        $verification = eZContentObjectReadVerification::fetch( $user->attribute( 'contentobject_id' ), $objectID );
        $status = $verification ? $verification->attribute( 'verified' ) : 2;

        return array( 'result' => $status );
    }

    function unreadContentObjects()
    {
        $user = eZUser::instance();
        $trashed = false;
        $useTree = true;
        $objects = & eZContentObjectReadVerification::fetchUnreadContentObjectsByUser( $user->attribute( 'contentobject_id' ), $trashed, $useTree );

        return array( 'result' => $objects );
    }
}

?>