#!/bin/sh
APP_PATH="/var/www/html"
echo "all params $@"
echo "installing composer dependencies"
composer install
# echo "applying db migrations"
# ${APP_PATH}/bin/console doctrine:migrations:migrate first
# ${APP_PATH}/bin/console doctrine:migrations:migrate
# ${APP_PATH}/bin/console doctrine:fixtures:load
echo "starting php-fpm"

# exec "$@" will run the command given by the command line parameters in such a way that the current process is replaced by it (if the exec is able to execute the command at all).
exec $@


