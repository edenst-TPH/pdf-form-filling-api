# PDF FORM FILLING (PFF) API 
[![Deploy to dev](https://github.com/Research-IT-Swiss-TPH/pdf-form-filling-api/actions/workflows/deploy_dev.yml/badge.svg)](https://github.com/Research-IT-Swiss-TPH/pdf-form-filling-api/actions/workflows/deploy_dev.yml)

Slim Framework powered API for PDF Form Filling.

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

###  Setup
[See Development Setup](/DEVELOPMENT.md)

