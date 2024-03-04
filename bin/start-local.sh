APP_ENVIRONMENT=local
echo "starting $APP_ENVIRONMENT environment"
echo

docker compose -f compose.dev.yml up --remove-orphans
