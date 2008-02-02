<?php

class eZContentObjectReadVerificationFilter
{
    function createSqlParts( $params )
    {
        $userID = $params[0];
        $read = $params[1];

        $tables = ', ezcontentobject_readverification';
        $joins = " AND ezcontentobject_readverification.contentobject_id=ezcontentobject.id
                   AND ezcontentobject_readverification.user_id=$userID
                   AND ezcontentobject_readverification.verified=$read";

        return array( 'tables' => $tables, 'joins'  => $joins, 'columns' => '' );
    }
}

?>