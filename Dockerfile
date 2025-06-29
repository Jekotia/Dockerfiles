FROM php:5.4-apache
 #:5.4-apache
#FROM jekotia/php_codesniffer

# #-> Linguistic Library
# RUN apt-get update
# RUN apt-get install -y \
# 		php-mysql
# #	&& rm -rf \
# #		/var/lib/apt/lists/* \
# RUN docker-php-ext-configure \
# 		mysql
# RUN	docker-php-ext-install \
# 		mysql

WORKDIR /var/www/html/
COPY source/web/ /var/www/html/
