<?php

require_once __DIR__ . '/../core/Database.php';

class JobQueue
{
    public static function push($type, $payload)
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO jobs (type, payload, status)
            VALUES (?, ?, 'pending')
        ");

        $stmt->execute([$type, json_encode($payload)]);
    }

    public static function next()
    {
        $db = Database::connect();

        $job = $db->query("
            SELECT * FROM jobs 
            WHERE status = 'pending' 
            ORDER BY id ASC 
            LIMIT 1
        ")->fetch(PDO::FETCH_ASSOC);

        if ($job) {
            $db->prepare("UPDATE jobs SET status='processing' WHERE id=?")
               ->execute([$job['id']]);
        }

        return $job;
    }

    public static function complete($id)
    {
        $db = Database::connect();
        $db->prepare("UPDATE jobs SET status='done' WHERE id=?")
           ->execute([$id]);
    }
}