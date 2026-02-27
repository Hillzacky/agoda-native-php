<?php

class Room
{
    public static function byProperty($propertyId)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM rooms WHERE property_id = ?");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}