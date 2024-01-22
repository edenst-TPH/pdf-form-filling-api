FROM php:8.1-fpm

RUN curl -L -C - --progress-bar -o /usr/local/bin/composer https://getcomposer.org/composer.phar
RUN chmod 755 /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    git
    zip 
    unzip 
    php-zip
    libpq-dev 

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo pdo_pgsql pgsql zip

#RUN docker-php-ext-install pdo pdo_pgsql pgsql zip
#RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install composer with multistage
#COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

CMD bash -c "composer install --prefer-dist"

