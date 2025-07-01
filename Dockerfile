FROM ghcr.io/jekotia/php5.4-apache:latest

RUN docker-php-ext-configure \
		mysql \
&&  docker-php-ext-install \
		mysql

WORKDIR /var/www/html/
COPY ./source/web/ /var/www/html/
