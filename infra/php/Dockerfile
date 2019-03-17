FROM php:fpm

RUN apt-get update
RUN apt-get install -y zlib1g-dev
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

COPY php.ini /usr/local/etc/php/

ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin