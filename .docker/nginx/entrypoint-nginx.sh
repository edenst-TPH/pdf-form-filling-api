#!/bin/sh
APP_PATH="/var/www/html"
echo "all params $@"

echo "installing certificates"

echo $APP_ENVIRONMENT

# certbot certonly --webroot -w /var/www/html -d 143.198.242.211.sslip.io -d www.143.198.242.211.sslip.io --email ekin.tertemiz@swisstph.ch --agree-tos

certbot --webroot -w /var/www/html --nginx -d 143.198.242.211.sslip.io -d www.143.198.242.211.sslip.io --email ekin.tertemiz@swisstph.ch --agree-tos

mkdir -p /etc/letsencrypt/ssl
cp -r -L /etc/letsencrypt/live/143.198.242.211.sslip.io/fullchain.pem /etc/letsencrypt/ssl/
cp -r -L /etc/letsencrypt/live/143.198.242.211.sslip.io/privkey.pem /etc/letsencrypt/ssl/

echo "starting nginx"

# exec "$@" will run the command given by the command line parameters in such a way that the current process is replaced by it (if the exec is able to execute the command at all).
exec "$@"
#exec /docker-entrypoint.sh $@

