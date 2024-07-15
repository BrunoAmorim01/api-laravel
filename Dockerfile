FROM php:8.3.9
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip libpq-dev supervisor
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql sockets zip
RUN mkdir /app
ADD . /app
WORKDIR /app
RUN cp ./.docker/web/my-supervisor.conf /etc/supervisor/conf.d/my-supervisor.conf
RUN composer install
CMD php artisan serve --host=0.0.0.0 --port $PORT
RUN "/usr/bin/supervisord"
EXPOSE $PORT
