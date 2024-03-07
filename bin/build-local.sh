APP_ENVIRONMENT=local
echo "starting $APP_ENVIRONMENT environment"

docker compose -f compose.local.yml up --remove-orphans --build -d
