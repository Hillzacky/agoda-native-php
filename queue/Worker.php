<?php

require_once 'JobQueue.php';
require_once __DIR__ . '/../engines/RateEngine.php';

while (true) {

    $job = JobQueue::next();

    if ($job) {

        $payload = json_decode($job['payload'], true);

        if ($job['type'] == 'sync_rate') {

            $engine = new RateEngine();
            $engine->syncYearlyRates(
                $payload['property_id'],
                $payload['base_rate']
            );
        }

        JobQueue::complete($job['id']);
    }

    sleep(5);
}