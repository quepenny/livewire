#!/bin/sh
# activate maintenance mode
/opt/cpanel/ea-php74/root/usr/bin/php artisan down
# update PHP dependencies
export COMPOSER_HOME=/home/peqxhg0iclb5
/opt/cpanel/ea-php74/root/usr/bin/php /opt/cpanel/composer/bin/composer install --no-interaction --optimize-autoloader --no-dev --prefer-dist
# --no-interaction Do not ask any interactive question
# --no-dev  Disables installation of require-dev packages.
# --prefer-dist  Forces installation from package dist even for dev versions.
# update database
/opt/cpanel/ea-php74/root/usr/bin/php artisan migrate --force
# --force  Required to run when in production.
# stop maintenance mode
/opt/cpanel/ea-php74/root/usr/bin/php artisan config:cache
/opt/cpanel/ea-php74/root/usr/bin/php artisan route:cache
/opt/cpanel/ea-php74/root/usr/bin/php artisan view:cache

/opt/cpanel/ea-php74/root/usr/bin/php artisan up