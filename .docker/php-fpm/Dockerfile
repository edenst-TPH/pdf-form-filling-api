FROM php:8.1-fpm

RUN apt-get -y update
#RUN curl -L -C - --progress-bar -o /usr/local/bin/composer https://getcomposer.org/composer.phar
#RUN chmod 755 /usr/local/bin/composer
#RUN apt-get install -y git

RUN apt-get install libpq-dev -y

RUN docker-php-ext-install  pdo pdo_pgsql pgsql
#RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

CMD bash -c "composer install"

