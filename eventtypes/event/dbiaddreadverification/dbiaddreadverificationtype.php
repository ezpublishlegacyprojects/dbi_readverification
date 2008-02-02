<?php

include_once( 'kernel/classes/ezworkflowtype.php' );

class DBIAddReadVerificationType extends eZWorkflowEventType
{
    function DBIAddReadVerificationType()
    {
        $this->eZWorkflowEventType( 'dbiaddreadverification', ezi18n( 'kernel/workflow/event', 'DBI add read verification' ) );
        $this->setTriggerTypes( array( 'content' => array( 'publish' => array( 'after' ) ) ) );
    }
    function &attributeDecoder( &$event, $attr )
    {
        $retValue = null;
        switch( $attr )
        {
            case 'selected_attributes':
            {
                $implodedAttributeList = $event->attribute( 'data_text1' );

                $attributeList = array();
                if ( $implodedAttributeList != '' )
                {
                    $attributeList = explode( ';', $implodedAttributeList );
                }
                return $attributeList;
            }

            default:
            {
                eZDebug::writeNotice( 'unknown attribute:' . $attr, 'DBIAddReadVerificationType' );
            }
        }
        return $retValue;
    }

    function typeFunctionalAttributes()
    {
        return array( 'selected_attributes' );
    }

    function customWorkflowEventHTTPAction( &$http, $action, &$workflowEvent )
    {
        $eventID = $workflowEvent->attribute( 'id' );

        switch ( $action )
        {
            case 'AddAttribute':
            {
                if ( $http->hasPostVariable( 'AttributeSelection_' . $eventID ) )
                {
                    $attributeID = $http->postVariable( 'AttributeSelection_' . $eventID );
                    $workflowEvent->setAttribute( 'data_text1', implode( ';', array_unique( array_merge( $this->attributeDecoder( $workflowEvent, 'selected_attributes' ), array( $attributeID ) ) ) ) );
                }
            } break;

            case 'RemoveAttributes':
            {
                if ( $http->hasPostVariable( 'DeleteAttributeIDArray_' . $eventID ) )
                {
                    $deleteList = $http->postVariable( 'DeleteAttributeIDArray_' . $eventID );
                    $currentList = $this->attributeDecoder( $workflowEvent, 'selected_attributes' );

                    if ( is_array( $deleteList ) )
                    {
                        $dif = array_diff( $currentList, $deleteList );
                        $workflowEvent->setAttribute( 'data_text1', implode( ';', $dif ) );
                    }
                }
            } break;

            default:
            {
                eZDebug::writeNotice( 'unknown custom action: ' . $action, 'DBIAddReadVerificationType' );
            }
        }
    }

    /*!
     \reimp
    */
    function execute( &$process, &$event )
    {
        $parameters = $process->attribute( 'parameter_list' );
        include_once( 'kernel/classes/ezcontentobject.php' );
        $objectID = $parameters['object_id'];
        $object =& eZContentObject::fetch( $objectID );

        // defer to cron, figuring out which users have read access can take a while and can cause out of memory errors or timeouts
        include_once( 'lib/ezutils/classes/ezsys.php' );
        if ( eZSys::isShellExecution() == false )
        {
            return EZ_WORKFLOW_TYPE_STATUS_DEFERRED_TO_CRON_REPEAT;
        }

        $datamap = $object->attribute( 'data_map' );
        $attributeIDList = $event->attribute( 'selected_attributes' );

        $mainNodeID = $object->attribute( 'main_node_id' );

        foreach ( $datamap as $attribute )
        {
            if ( in_array( $attribute->attribute('contentclassattribute_id'), $attributeIDList ) )
            {
                eZDebug::writeDebug( 'found matching attribute: ' . $attribute->attribute('contentclassattribute_id'), 'DBIAddReadVerificationType' );

                $dataTypeString = $attribute->attribute( 'data_type_string' );
                if ( $dataTypeString != 'ezboolean' )
                {
                    $attributeName = $attribute->attribute( 'contentclass_attribute_name' );
                    eZDebug::writeError( "attribute '$attributeName' has datatype '$dataTypeString', expected: ezboolean", 'DBIAddReadVerificationType::execute' );
                    continue;
                }

                $checked = $attribute->attribute( 'content' );

                if ( $checked )
                {
                    include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );
                    $def = eZUser::definition();
                    $users = eZPersistentObject::fetchObjectList( $def );

                    foreach ( $users as $user )
                    {
                        if ( !$user->attribute( 'is_enabled' ) )
                        {
                            continue;
                        }

                        $userID = $user->attribute( 'contentobject_id' );
                        eZUser::setCurrentlyLoggedInUser( $user, $userID );

                        // temporary fix for bug http://issues.ez.no/8388
                        if ( isset( $GLOBALS['ezpolicylimitation_list']['content']['read'] ) )
                        {
                            unset( $GLOBALS['ezpolicylimitation_list']['content']['read'] );
                        }

                        // reset permission caching inside content object
                        $permissions = array();
                        $object->setPermissions( $permissions );

                        if ( !$object->canRead() )
                        {
                            continue;
                        }

                        include_once( 'extension/dbi_readverification/classes/ezcontentobjectreadverification.php' );
                        $verification = eZContentObjectReadVerification::fetch( $userID, $objectID );

                        if ( $verification )
                        {
                            $verification->reset();
                            $verification->store();
                        }
                        else
                        {
                            $verification = eZContentObjectReadVerification::create( $userID, $objectID );
                        }
                    }
                }
            }
        }

        return EZ_WORKFLOW_TYPE_STATUS_ACCEPTED;
    }
}

eZWorkflowEventType::registerType( 'dbiaddreadverification', 'dbiaddreadverificationtype' );

?>
