<?php

class Property
{
    public static function all()
    {
        $db = Database::connect();
        return $db->query("SELECT * FROM properties")->fetchAll(PDO::FETCH_ASSOC);
    }
}