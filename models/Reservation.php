<?php

class Reservation
{
    public static function save($data)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO reservations
            (agoda_booking_id, status, checkin, checkout, guest_name, total_amount)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['booking_id'],
            $data['status'],
            $data['checkin'],
            $data['checkout'],
            $data['guest'],
            $data['amount']
        ]);
    }
}