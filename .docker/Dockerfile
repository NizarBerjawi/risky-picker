FROM php:7.3-fpm

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

# Install dependencies
RUN apt-get update && \
  apt-get upgrade -y && \
  apt-get install -y --no-install-recommends \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
  && rm -rf /var/lib/apt/lists/*

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql \
  # Install the PHP gd library
  && docker-php-ext-configure gd \
    --with-jpeg-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# RUN chown -R www-data:www-data \
#   /var/www/storage \
#   /var/www/bootstrap/cache

# RUN chgrp -R www-data /var/www/storage /var/www/bootstrap/cache && \
#   chmod -R ug+rwx /var/www/storage /var/www/bootstrap/cache

# Expose port 9000 and start php-fpm server
CMD ["php-fpm"]

EXPOSE 9000
