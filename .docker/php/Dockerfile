FROM php:8.0.0-fpm

USER root

# Install dependencies
RUN apt-get update && apt-get install -y \
    apt-utils \
    build-essential \
    openssl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libicu-dev \
    libgettextpo-dev \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    libzip-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    zip \
    unzip \
    git \
    supervisor

# Clear cache
RUN apt-get clean \
    && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql \
    gd \
    mbstring \
    mysqli \
    zip \
    bcmath \
    sockets \
    exif \
    pcntl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#xdebug
RUN pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=docker" >> /usr/local/etc/php/conf.d/xdebug.ini
