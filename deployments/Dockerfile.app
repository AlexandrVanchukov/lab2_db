FROM php:8.1-fpm

RUN apt update && apt upgrade -y && apt install -y nginx

RUN apt-get install -y libzip-dev netcat-openbsd

RUN docker-php-ext-install zip pdo_mysql mysqli


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer    

WORKDIR /var/www/html

COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN /usr/local/bin/composer install

EXPOSE 80
CMD service nginx start && php-fpm
