echo "Creating certificate.."

if [[ ${APP_ENV} == "dev" ]]; then
error_msg "Creating certificate in environment 'dev' is not allowed."
fi

if [[ ${args[--run]} ]]
then
    echo "[RUN]"
    docker compose -f $APP_ROOT/compose.yml -f $APP_ROOT/compose.$APP_ENV.yml run --rm certbot certonly --webroot -w /var/www/certbot/ -d $SSL_DOMAIN -d www.$SSL_DOMAIN --email $SSL_EMAIL --agree-tos --non-interactive 

    cp -Lr .docker/certbot/conf/live/ .docker/nginx/ssl/
else
    echo "[DRY RUN]"
    docker compose -f $APP_ROOT/compose.yml -f $APP_ROOT/compose.$APP_ENV.yml run --rm certbot certonly --webroot -w /var/www/certbot/ -d $SSL_DOMAIN -d www.$SSL_DOMAIN --email $SSL_EMAIL --agree-tos --non-interactive --dry-run
fi