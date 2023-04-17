FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends cron vim libssl-dev zlib1g-dev curl git unzip netcat libxml2-dev libpq-dev libzip-dev && \
    pecl install apcu && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install -j$(nproc) zip opcache intl pdo_pgsql pgsql && \
    docker-php-ext-enable apcu pdo_pgsql sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENV TZ=Europe/Paris
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www/Back

COPY ./Back/composer.* .
COPY ./Back/symfony.lock .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./Back/cronjobs /etc/cron.d/cronjobs
RUN chmod 0744 /etc/cron.d/cronjobs
RUN crontab /etc/cron.d/cronjobs
RUN touch /var/log/cron.log

EXPOSE 9000

CMD php-fpm && composer install --no-scripts --prefer-source && php bin/console d:m:m --n && php bin/console d:f:l -n && cron
