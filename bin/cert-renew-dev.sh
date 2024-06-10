echo "Renewing Certificate.."
echo

docker compose -f compose.dev.yml run --rm certbot renew