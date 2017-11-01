FROM php:7.1.11-fpm
	
RUN apt-get update 
RUN apt-get install -y libmcrypt-dev mysql-client 
RUN docker-php-ext-install mcrypt pdo_mysql

WORKDIR /var/www
