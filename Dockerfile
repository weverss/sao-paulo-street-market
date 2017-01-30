FROM ubuntu:16.04

RUN apt-get update && apt-get install -y \
    php \
    php-cli \
    php-xml \
    php-mcrypt \
    php-mbstring \
    php-mysql \
    php-sqlite3 \
    php-xdebug \
    iputils-ping
