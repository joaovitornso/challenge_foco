FROM php:8.2-fpm

WORKDIR /var/www

RUN rm -rf /var/www/html

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    apt-utils \
    libonig-dev \
    sqlite3 \
    libsqlite3-dev

# RUN docker-php-ext-install pdo-pgsql mbstring exif
RUN docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd sockets
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-enable pdo_sqlite


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel user

COPY . .

COPY --chown=user:laravel . /var/www

USER user

EXPOSE 9000

CMD ["php-fpm"]