FROM php:7.3-fpm

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

ENV php_conf /usr/local/etc/php-fpm.conf
ENV fpm_conf /usr/local/etc/php-fpm.d/www.conf
# ENV php_vars /usr/local/etc/php/conf.d/docker-vars.ini


# Install dependencies
RUN apt-get update && \
  apt-get upgrade -y && \
  apt-get install -y --no-install-recommends \
    wget \
    curl \
    git \
    vim \
    zip \
    unzip \
    openssh-client \
    ca-certificates \
    supervisor \
    build-essential \
    libz-dev \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev

# Install extensions
RUN docker-php-ext-configure gd \
    --with-gd \
    --with-jpeg-dir=/usr/lib \
    --with-png-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd pdo_mysql exif json


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --install-dir=/usr/bin --filename=composer && \
    rm composer-setup.php && \
    composer global require hirak/prestissimo --no-plugins --no-scripts

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html

# Set working directory
WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]

