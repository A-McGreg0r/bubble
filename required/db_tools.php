<?php
require "connectdb.php";


//Securaty must be implmented before deploment!!


class sqlquery
{

    static function querryuserinfo($conn, $db_table, $characterID, $characterName)
    {
        $sql = "SELECT $characterID from '.$db_table.' ( $characterID,$characterName)";
        return $sql;
    }
}

;

class sqlpost
{
    static function postuserinfo($conn, $db_table, $characterID, $characterName)
    {
        $sql = "INSERT INTO '.$db_table.' ( $characterID,$characterName)";
    }

}

;

