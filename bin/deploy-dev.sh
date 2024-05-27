#!/bin/bash

# fstd - filter standard output|error
# description: redirects stdout and stdout based on exit codes
# author: tertek
fstd() {
  eval "$@ 1>stdout.tmp 2>stderr.tmp"
  retVal=$?

  if [ $retVal -eq 0 ]; then
    cat stdout.tmp >&1
  else
    cat stderr.tmp >&2
  fi

  rm stdout.tmp
  rm stderr.tmp
}

# deployment steps
# 1. sync repository
# 2. start containers
# 3. migrate & seed database
if [ -d "pdf-api" ]; then

    echo "### Reset Database (Rollback to t=0)"
    fstd docker compose -f compose.dev.yml run --rm -it php-fpm php vendor/bin/phinx migrate -t 0
    echo "### Done"
    echo

    echo "### Sync repository"
    cd ~/pdf-api
    fstd git fetch
    fstd git checkout dev
    fstd git pull
    echo "### Done"
    echo

    echo "### Restart containers"
    fstd docker compose -f compose.dev.yml restart
    echo "### Done"
    echo


else

    echo "### Clone repository"
    fstd git clone https://github.com/Research-IT-Swiss-TPH/pdf-api.git
    cd ~/pdf-api
    fstd git fetch
    fstd git checkout dev
    fstd git pull
    echo "### Done"
    echo 
    
    echo "### Start Containers"
    fstd docker compose -f compose.dev.yml up -d
    echo "### Done"
    echo
fi

echo "### Migrate Database"
fstd docker compose -f compose.dev.yml run --rm -it php-fpm php vendor/bin/phinx migrate
echo "### Done"
echo

echo "### Seed Database"
fstd docker compose -f compose.dev.yml run php-fpm php vendor/bin/phinx seed:run
echo "### Done"
echo 

echo "Successfully deployed development environment"

