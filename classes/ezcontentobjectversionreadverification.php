<?php

include_once( "kernel/classes/ezpersistentobject.php" );

class eZContentObjectVersionReadVerification extends eZPersistentObject
{
    function eZContentObjectVersionReadVerification( $row )
    {
        $this->eZPersistentObject( $row );
    }

    function definition()
    {
        $def = array( "fields" => array( "contentobject_id" => array( "name" => "contentobject_id",
                                                                      "datatype" => "integer",
                                                                      "required" => false ),
                                         "contentobject_version" => array( "name" => "contentobject_version",
                                                                           "datatype" => "integer",
                                                                           "required" => false ),
                                         "user_id" => array( "name" => "user_id",
                                                             "datatype" => "integer",
                                                             "required" => false ),
                                         "time" => array( "name" => "time",
                                                          "datatype" => "integer",
                                                          "required" => false ) ),
                      "keys" => array( "contentobject_id",
                                       "contentobject_version",
                                       "user_id" ),
                      "function_attributes" => array(),
                      "class_name" => "eZContentObjectVersionReadVerification",
                      "sort" => array(),
                      "name" => "ezcontentobjectversion_readverification" );
        return $def;
    }

    /*!
     \static
    */
    function &fetchContentObjectVersionInfo( $objectID, $userID )
    {
        $versionInfo = array();

        $conds = array( 'contentobject_id' => $objectID );
        $sorts = array( 'modified' => 'desc' );

        include_once( 'kernel/classes/ezcontentobjectversion.php' );
        $def = eZContentObjectVersion::definition();

        $objects =& eZPersistentObject::fetchObjectList( $def, null, $conds, $sorts );

        $verConds = array( 'contentobject_id' => $objectID, 'user_id' => $userID );
        $verDef = eZContentObjectVersionReadVerification::definition();

        $verifications = eZPersistentObject::fetchObjectList( $verDef, null, $verConds );
        foreach ( $objects as $object )
        {
            $info = array( 'contentobject_version' => $object );

            foreach ( $verifications as $verification )
            {
                if ( $verification->attribute( 'contentobject_version' ) == $object->attribute( 'version' ) )
                {
                    $info['contentobjectversion_readverification'] = $verification;
                    break;
                }
            }
            $versionInfo[] = $info;
        }

        return $versionInfo;
    }

    /*!
     \static
    */
    function cleanupPurgedContent()
    {
        $db =& eZDB::instance();

        $db->query( 'DELETE FROM ezcontentobjectversion_readverification
                     WHERE NOT EXISTS
                         (SELECT * FROM ezcontentobject_version v
                          WHERE v.contentobject_id=contentobject_id
                            AND v.version=contentobject_version)' );
    }
}

?>