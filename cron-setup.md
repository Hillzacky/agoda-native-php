##Permission
```
chmod -R 755 agoda-native-php
```
##Test from Command
```
php monitoring/HealthCheck.php
```
##CronSettings
```
*/5 * * * * php /var/www/agoda-native-php/cron/pull_reservations.php
*/15 * * * * php /var/www/agoda-native-php/cron/sync_rates.php
*/15 * * * * php /var/www/agoda-native-php/cron/sync_inventory.php
* * * * * php /var/www/agoda-native-php/queue/Worker.php
```