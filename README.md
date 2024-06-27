# PDF FORM FILLING (PFF) API 
[![Deploy to dev](https://github.com/Research-IT-Swiss-TPH/pdf-form-filling-api/actions/workflows/deploy_dev.yml/badge.svg)](https://github.com/Research-IT-Swiss-TPH/pdf-form-filling-api/actions/workflows/deploy_dev.yml)

Slim Framework powered API for PDF Form Filling.

## Notice
Fetching container images behind company proxy with self-signed certificate may fail. In such case, exiting network is recommended for ease of development.

## Developers
dev,test and prod environment with using [multiple docker compose](https://docs.docker.com/compose/multiple-compose-files/merge/) files.

### Requirements
- Git
- Docker Engine 
- Composer

### Overview

The docker compose consists of four services:

1. nginx
Webserver

2. php-fpm
PHP FastCGI implementation
The app directory includes the Slim Framework [slim-skeleton](https://github.com/odan/slim4-skeleton) as a starting point.

3. postgres
Database

4. adminer
Database Management, web-based


## Local Development Environment

### Clone repository and switch to dev branch

```bash
    clone git git@github.com:Research-IT-Swiss-TPH/pdf-api.git
    cd pdf-api
    git checkout dev
```

### Build docker containers and run with compose

```bash
./bin/build-local.sh
..
```

### Install composer dependencies within php-fpm container
```bash
./bin/install-local.sh
```

### Login to local postgres database with adminer

System: PostgresSQL
Server: postgres
Username: postgres
Password: password
Database: postgres

Set to permanent login

###  Development Environment

Web: http://143.198.242.211.nip.io/

Adminer: http://143.198.242.211.nip.io:8080

### Environmnet variables

```bash
DB_USER=
DB_PASSWORD=
```

### SSL certificates

#### Issue and setup SSL certitifactes with certbot
This has to be done in initial container setup

```bash
./bin/certs-dev # dry-run

./bin/certs-dev --run # actual run
```

#### Renew SSL certificates
Needs to be manually renewed every 90 days (or added to cron for automation, tbd.)

```bash
docker composer -f compose.dev.yml certbot run renew
# https://www.nginx.com/blog/using-free-ssltls-certificates-from-lets-encrypt-with-nginx/
```