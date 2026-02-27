<?php

require_once __DIR__ . '/../services/YCSService.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../core/Database.php';

class ReservationEngine
{
    private $ycs;

    public function __construct()
    {
        $this->ycs = new YCSService();
    }

    public function pullLatest()
    {
        $from = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        $to   = date('Y-m-d H:i:s');

        $response = $this->ycs->getReservations($from, $to);

        if (!$response->isSuccess()) {
            Logger::write("RES_PULL_FAIL", $response->status);
            return;
        }

        $bookings = $response->json();

        foreach ($bookings as $booking) {

            if (!$this->exists($booking['booking_id'])) {

                Reservation::save([
                    'booking_id' => $booking['booking_id'],
                    'status'     => $booking['status'],
                    'checkin'    => $booking['checkin'],
                    'checkout'   => $booking['checkout'],
                    'guest'      => $booking['guest_name'],
                    'amount'     => $booking['total_amount']
                ]);
            }
        }

        Logger::write("RES_PULL", "Completed");
    }

    private function exists($bookingId)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM reservations WHERE agoda_booking_id = ?");
        $stmt->execute([$bookingId]);
        return $stmt->fetch();
    }
}