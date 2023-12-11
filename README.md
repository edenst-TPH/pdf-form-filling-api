# PDF API
Slim Framework powered API for PDF form filling.

## Notice
Fetching container images behind company proxy with self-signed certificate may fail. In such case exiting network is recommended for ease of development.

## Requirements
- Git
- Docker Engine 
- Composer

## Development Setup

The docker compose consists of four services:

1. nginx
Webserver

2. php-fpm
PHP FastCGI implementation

3. postgres
Database

4. adminer
Database Management, web-based

The app directory includes the slim-skeleton by odan as a starting point. https://github.com/odan/slim4-skeleton

Temporary not so elegant setup:

```bash
    clone git git@github.com:Research-IT-Swiss-TPH/pdf-api.git
    cd pdf-api
    composer install --working-dir=/app
    docker compose -f compose.dev.yml up
```

