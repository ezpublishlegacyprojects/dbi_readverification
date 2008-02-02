<?php

$FunctionList = array();
$FunctionList['status'] = array(
    'operation_types' => array( 'read' ),
    'call_method' => array( 'include_file' => 'extension/dbi_readverification/modules/readverification/readverificationfunctioncollection.php',
                           'class' => 'ReadVerificationFunctionCollection',
                           'method' => 'status' ),
    'parameter_type' => 'standard',
    'parameters' => array( array( 'name' => 'object_id',
                                 'type' => 'integer',
                                 'required' => true ) ) );

$FunctionList['unread_objects'] = array(
    'operation_types' => array( 'read' ),
    'call_method' => array( 'include_file' => 'extension/dbi_readverification/modules/readverification/readverificationfunctioncollection.php',
                           'class' => 'ReadVerificationFunctionCollection',
                           'method' => 'unreadContentObjects' ),
    'parameter_type' => 'standard',
    'parameters' => array() );

?>