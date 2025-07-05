FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev libonig-dev zlib1g-dev \
    && docker-php-ext-install intl pdo pdo_pgsql zip opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html
