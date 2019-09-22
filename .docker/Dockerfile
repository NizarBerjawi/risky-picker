FROM php:7.3-fpm

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

# Set Environment Variables
ENV DEBIAN_FRONTEND noninteractive

# Replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

# Install dependencies
RUN apt-get update && \
  apt-get upgrade -y && \
  apt-get install -y --no-install-recommends \
    curl \
    zip \
    unzip \
    openssh-client \
    apt-transport-https \
    ca-certificates \
    build-essential \
    libz-dev \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev && \
  docker-php-ext-configure gd \
    --with-gd \
    --with-jpeg-dir=/usr/lib \
    --with-png-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 && \
  docker-php-ext-install gd pdo_mysql exif json

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --install-dir=/usr/bin --filename=composer && \
    rm composer-setup.php && \
    composer global require hirak/prestissimo --no-plugins --no-scripts

# Install node js
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Clean up
RUN apt-get -y autoclean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Copy all the codebase
COPY . /var/www/html

# Give the webserver ownership of the storage and cache folders
RUN chown -R www:www \
  /var/www/html/storage \
  /var/www/html/bootstrap/cache

# Give the webserver the rights to read and write to storage and cache
RUN chgrp -R www /var/www/html/storage /var/www/html/bootstrap/cache && \
  chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# Set working directory
WORKDIR /var/www/html

USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
