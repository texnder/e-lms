FROM php:7.2-apache

LABEL maintainer="inderjeetchohana1431996@gamil.com"

COPY .docker/vhost.conf /etc/apache2/apache2.conf

RUN docker-php-ext-install mysqli pdo_mysql

RUN a2enmod rewrite

RUN service apache2 restart
