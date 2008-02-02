<?php

include_once( "kernel/classes/ezpersistentobject.php" );

class eZContentObjectReadVerification extends eZPersistentObject
{
    function eZContentObjectReadVerification( $row )
    {
        $this->eZPersistentObject( $row );
    }

    function definition()
    {
        $def = array( "fields" => array( "contentobject_id" => array( "name" => "contentobject_id",
                                                                      "datatype" => "integer",
                                                                      "required" => false ),
                                         "user_id" => array( "name" => "user_id",
                                                             "datatype" => "integer",
                                                             "required" => false ),
                                         "verified" => array( "name" => "verified",
                                                          "datatype" => "integer",
                                                          "required" => false,
                                                          "default" => 0 ) ),
                      "keys" => array( "contentobject_id",
                                       "user_id" ),
                      "function_attributes" => array( 'current_version' => 'currentVersion' ),
                      "class_name" => "eZContentObjectReadVerification",
                      "sort" => array(),
                      "name" => "ezcontentobject_readverification" );
        return $def;
    }

    /*!
     \static
    */
    function fetch( $userID, $objectID )
    {
        $conds = array(
            'user_id' => $userID,
            'contentobject_id' => $objectID
        );

        $def = eZContentObjectReadVerification::definition();
        return eZPersistentObject::fetchObject( $def, null, $conds );
    }

    /*
     \static
    */
    function create( $userID, $contentObjectID )
    {
        $row = array(
            'user_id' => $userID,
            'contentobject_id' => $contentObjectID );
        $object = new eZContentObjectReadVerification( $row );
        $object->store();
        return $object;
    }

    function reset()
    {
        $this->setAttribute( 'verified', 0 );
    }

    /*
     \private
     \static
    */
    function fetchContentObjectsByUser( $userID, $read = 1, $trashed = false, $useTree = false )
    {
        if ( $useTree )
        {
            include_once( 'extension/ezcontentobjectfetcher/classes/ezcontentobjectfetcher.php' );
            $objects =& eZContentObjectFetcher::objectSubtree(
                array( 'ExtendedAttributeFilter' => array( 'id' => 'ReadVerificationFilter',
                                                           'params' => array( $userID, $read ) ) ),
                1 );
        }
        else
        {
            $customTables = array( 'ezcontentobject_readverification' );
            include_once( 'kernel/classes/ezcontentobject.php' );

            // to show trashed objects or not
            if ( $trashed )
            {
                $customConds = " WHERE ezcontentobject_readverification.contentobject_id=ezcontentobject.id
                           AND ezcontentobject_readverification.user_id=$userID
                           AND ezcontentobject_readverification.verified=$read";
                $conds = null;
            }
            else
            {
                $customConds = " AND ezcontentobject_readverification.contentobject_id=ezcontentobject.id
                           AND ezcontentobject_readverification.user_id=$userID
                           AND ezcontentobject_readverification.verified=$read";
                $conds = array( 'status' => EZ_CONTENT_OBJECT_STATUS_PUBLISHED );
            }

            $def = eZContentObject::definition();
            $objects =& eZPersistentObject::fetchObjectList( $def, null, $conds, null, null, true, false, null, $customTables, $customConds );
        }

        return $objects;
    }

    /*!
     \static
    */
    function fetchReadContentObjectsByUser( $userID, $trashed = true, $useTree = false )
    {
        return eZContentObjectReadVerification::fetchContentObjectsByUser( $userID, 1, $trashed, $useTree );
    }

    /*!
     \static
    */
    function fetchUnreadContentObjectsByUser( $userID, $trashed = true, $useTree = false )
    {
        return eZContentObjectReadVerification::fetchContentObjectsByUser( $userID, 0, $trashed, $useTree );
    }

    /*!
     \static
    */
    function fetchContentObjects( $sorts = false, $trashed = true )
    {
        $customTables = array( 'ezcontentclass' );
        $ordering = array();;
        if ( !$sorts )
        {
            $ordering[] = 'o.modified DESC';
        }
        else
        {
            foreach ( $sorts as $field => $direction )
            {
                $ordering[] = "$field $direction";
            }
        }
        $orderingString = implode( ', ', $ordering );

        $trashedCondition = $trashed ? "AND o.status = " . EZ_CONTENT_OBJECT_STATUS_PUBLISHED : '';

        $query = "SELECT o.*
          FROM ezcontentobject o, ezcontentclass c
          WHERE o.contentclass_id=c.id
            AND c.version=0
            AND o.id IN ( SELECT DISTINCT contentobject_id FROM ezcontentobject_readverification )
            $trashedCondition
          ORDER BY $orderingString";

        include_once( 'kernel/classes/ezcontentobject.php' );
        $def = eZContentObject::definition();

        $db =& eZDB::instance();
        $rows =& $db->arrayQuery( $query );

        $objects = eZPersistentObject::handleRows( $rows, 'eZContentObject', true );
        //eZPersistentObject::fetchObjectList( $def, null, $conds, $sorts, null, true, false, null, $customTables, $customConds );
        return $objects;
    }

    /*!
     \static
    */
    function fetchUsers()
    {
        $sorts = array( 'name' => 'asc' );

        $customConds = " WHERE ezcontentobject.id IN ( SELECT DISTINCT user_id FROM ezcontentobject_readverification )";

        include_once( 'kernel/classes/ezcontentobject.php' );
        $def = eZContentObject::definition();
        $objects =& eZPersistentObject::fetchObjectList( $def, null, null, $sorts, null, true, false, null, null, $customConds );
        return $objects;
    }

    /*!
     \private
     \static
    */
    function fetchUsersByContentObject( $objectID, $read = 1 )
    {
        $customTables = array( 'ezcontentobject_readverification' );

        $customConds = " AND ezcontentobject_readverification.contentobject_id=$objectID
                               AND ezcontentobject_readverification.user_id=ezcontentobject.id
                               AND ezcontentobject_readverification.verified=$read";

        include_once( 'kernel/classes/ezcontentobject.php' );
        $def = eZContentObject::definition();
        $conds = array( 'status' => EZ_CONTENT_OBJECT_STATUS_PUBLISHED );
        $objects =& eZPersistentObject::fetchObjectList( $def, null, $conds, null, null, true, false, null, $customTables, $customConds );
        return $objects;
    }

    /*!
     \static
    */
    function fetchUsersByReadContentObject( $objectID )
    {
        return eZContentObjectReadVerification::fetchUsersByContentObject( $objectID );
    }

    /*!
     \static
    */
    function fetchUsersByUnreadContentObject( $objectID )
    {
        return eZContentObjectReadVerification::fetchUsersByContentObject( $objectID, 0 );
    }

    /*
     shortcut to current_version attribute of eZContentObject
    */
    function currentVersion()
    {
        $object = eZContentObject::fetch( $this->attribute( 'contentobject_id' ) );
        return $object->attribute( 'current_version' );
    }

    function verifyAsRead()
    {
        $this->setAttribute( 'verified', 1 );
        $this->store();

        $currentVersion = $this->attribute( 'current_version' );

        $row = array(
            'contentobject_id'      => $this->attribute( 'contentobject_id' ),
            'contentobject_version' => $currentVersion,
            'user_id'               => $this->attribute( 'user_id' ),
            'time'                  => time() );
        include_once( 'extension/dbi_readverification/classes/ezcontentobjectversionreadverification.php' );
        $versionVerification = new eZContentObjectVersionReadVerification( $row );
        $versionVerification->store();

        // clear the view cache

        include_once( 'kernel/classes/ezcontentcachemanager.php' );
        eZContentCacheManager::clearContentCacheIfNeeded( $this->attribute( 'contentobject_id' ), $currentVersion );
    }

    /*!
     \static
    */
    function cleanupPurgedContent()
    {
        $db =& eZDB::instance();

        $db->begin();

        $db->query( 'DELETE FROM ezcontentobject_readverification WHERE contentobject_id NOT IN (SELECT id FROM ezcontentobject)' );

        include_once( 'extension/dbi_readverification/classes/ezcontentobjectversionreadverification.php' );
        eZContentObjectVersionReadVerification::cleanupPurgedContent();

        $db->commit();
    }
}

?>
