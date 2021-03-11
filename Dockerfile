FROM php:8.0-fpm

RUN apt-get update
RUN apt-get install -y autoconf pkg-config libssl-dev libzip-dev git gcc make autoconf libc-dev vim unzip
RUN docker-php-ext-install bcmath pdo pdo_mysql mysqli sockets zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN pecl install pcov \
    && docker-php-ext-enable pcov

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR /home/guess

ENTRYPOINT ["php", "-S", "0.0.0.0:8080", "-t", "/home/guess/public/"]
