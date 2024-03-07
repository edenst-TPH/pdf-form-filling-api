#!/bin/sh
APP_PATH="/var/www/html"
echo "all params $@"

# echo "installing certificates"

# certbot certonly --standalone -d 143.198.242.211.sslip.io -d www.143.198.242.211.sslip.io --email ekin.tertemiz@swisstph.ch --agree-tos --non-interactive

echo "starting nginx"

# exec "$@" will run the command given by the command line parameters in such a way that the current process is replaced by it (if the exec is able to execute the command at all).
exec "$@"
#exec /docker-entrypoint.sh $@

