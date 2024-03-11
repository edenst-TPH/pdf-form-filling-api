echo "Creating Certificate.."

if [ "$1" == "--run" ]
then 
    echo "[RUN]"
    docker compose -f compose.dev.yml run --rm certbot certonly --webroot -w /var/www/certbot/ -d 143.198.242.211.sslip.io -d www.143.198.242.211.sslip.io --email pdf-api@swisstph.ch --agree-tos --non-interactive 

    cp -Lr .docker/certbot/conf/live/ .docker/nginx/ssl/

else
    echo "[DRY RUN]"
    docker compose -f compose.dev.yml run --rm certbot certonly --webroot -w /var/www/certbot/ -d 143.198.242.211.sslip.io -d www.143.198.242.211.sslip.io --email pdf-api@swisstph.ch --agree-tos --non-interactive --dry-run
fi