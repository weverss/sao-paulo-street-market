FROM ubuntu:16.04

RUN apt-get update && apt-get install -y \
    php \
    php-cli \
    php-xmlrpc \
    php-mcrypt \
    php-mysql \
    php-sqlite3 \
    php-xdebug \
    mysql-client \
    composer
