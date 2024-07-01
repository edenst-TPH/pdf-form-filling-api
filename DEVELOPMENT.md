# Development

> [!NOTE]
> Fetching container images behind company proxy with self-signed certificate may fail. In such case, exiting network is recommended for ease of development.

## Requirements & Recommendations
- Docker
- Visual Code (recommended)
- "httpyac" Visual Code extension (recommended)

## Setup Local Development Environment

### Clone repository and switch to dev branch

```bash
    clone git git@github.com:Research-IT-Swiss-TPH/pdf-api.git
    cd pdf-api
    git checkout dev
```

### Build docker containers and run with compose

```bash
./bin/cli container start
```

### Install composer dependencies within php-fpm container
```bash
./bin/cli install
```

### Login to local postgres database with adminer

System: PostgresSQL
Server: postgres
Username: postgres
Password: password
Database: postgres

## Setup Remote Development Environment
Web: http://143.198.242.211.nip.io/
Adminer: http://143.198.242.211.nip.io:8080

### Environmnet variables
Define necessary environment variables
```bash
DB_USER=
DB_PASSWORD=
```

### Install SSL certificates

#### Issue and setup SSL certitifactes with certbot
This has to be done in initial container setup

```bash
./bin/cli cert create # dry-run

./bin/cli cert create --run # actual run
```

Requires env variable SSL_DOMAIN to be setup, defaults to 143.198.242.211.sslip.io.

#### Renew SSL certificates
Needs to be manually renewed every 90 days (or added to cron for automation, tbd.)

```bash
./bin/cli cert renew
# https://www.nginx.com/blog/using-free-ssltls-certificates-from-lets-encrypt-with-nginx/
```