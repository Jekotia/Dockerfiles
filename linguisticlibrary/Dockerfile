FROM php:5.4-apache
#FROM jekotia/php_codesniffer

#-> Linguistic Library
RUN apt-get update \
	&& apt-get install -y \
		php5-mysql \
	&& rm -rf \
		/var/lib/apt/lists/* \
	&& docker-php-ext-configure \
		mysql \
	&& docker-php-ext-install \
		mysql

WORKDIR /var/www/html/
COPY web/ /var/www/html/
