APP_ENVIRONMENT=local
echo "starting $APP_ENVIRONMENT environment"
echo

docker compose -f compose.local.yml up -d
