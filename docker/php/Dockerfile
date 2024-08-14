# Начинаем с официального образа PHP 8.2 FPM на базе Alpine
FROM php:8.2-fpm-alpine

# Устанавливаем UID и GID по умолчанию через аргументы сборки
ARG PUID=1000
ARG PGID=1000

# Устанавливаем необходимые пакеты и обновляем идентификаторы пользователя/группы
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Переходим в режим root для установки системных зависимостей
USER root

# Копируем файлы Composer в контейнер
COPY composer.json composer.lock ./

# Устанавливаем системные зависимости и PHP-расширения, необходимые для Yii2
RUN apk add --no-cache \
        autoconf \
        g++ \
        make \
        icu-dev \
        zlib-dev \
        libzip-dev \
        bash \
        git \
        openssh-client \
        oniguruma-dev \
        libpng-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo \
        pdo_mysql \
        mysqli \
        zip \
        bcmath \
        mbstring \
        exif \
    && apk add --no-cache $PHPIZE_DEPS linux-headers \
    && pecl install xdebug-3.3.2 \
    && docker-php-ext-enable xdebug

# Копируем пользовательскую конфигурацию php.ini
COPY docker/php/php.ini /usr/local/etc/php/php.ini
    
# Копируем конфигурацию xdebug
COPY docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Копируем Composer из официального образа Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Возвращаемся к пользователю www-data
USER www-data

# Устанавливаем рабочую директорию
WORKDIR /var/www/html
