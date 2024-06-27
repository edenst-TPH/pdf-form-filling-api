echo "Renewing Certificate.."
echo

if [[ ${APP_ENV} == "dev" ]]; then
error_msg "Renewing certificate in environment 'dev' is not allowed."
fi

docker compose -f $APP_ROOT/compose.yml -f $APP_ROOT/compose.$APP_ENV.yml run --rm certbot renew