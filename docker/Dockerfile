FROM php:8.2-fpm AS php

ARG host_uid
ENV TZ=Europe/Kiev

## User configuration
ARG SYSTEM_USER_ID
ARG SYSTEM_GROUP_ID

ARG CONTAINER_USER_NAME=app-container

RUN groupadd --gid $SYSTEM_GROUP_ID -r $CONTAINER_USER_NAME
RUN useradd -u $SYSTEM_USER_ID -g $CONTAINER_USER_NAME -ms /bin/bash $CONTAINER_USER_NAME

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && apt-get install -y vim git curl sudo libpq-dev postgresql; \
	chown -R app-container /var/www
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_pgsql

## Install Redis
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

COPY php/php.ini /usr/local/etc/php/conf.d/custom-php.ini

RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail
RUN echo 'sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025' > /usr/local/etc/php/conf.d/custom-php.ini

WORKDIR /var/www/html

USER app-container
