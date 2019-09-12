FROM debian:stretch

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

# Set working directory
WORKDIR /var/www

# Set timezone
ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Copy composer files
COPY composer.lock composer.json /var/www/

# # Install dependencies
RUN apt-get update && \
  apt-get upgrade -y && \
  apt-get install -y --no-install-recommends \
    apt-utils \
    gnupg \
    lsb-release \
    apt-transport-https \
    ca-certificates \
    git \
    vim \
    wget \
    zip \
    unzip && \
  wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
  echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php7.3.list && \
  apt-get update && \
  apt-get install -y --no-install-recommends \
    php7.3 \
    php7.3-cli \
    php7.3-fpm \
    php7.3-common \
    php7.3-pdo \
    php7.3-mysql \
    php7.3-mbstring \
    php7.3-bcmath \
    php7.3-gd \
    php7.3-curl \
    php7.3-zip \
    php7.3-xml \ &&





#     php7.3
    # build-essential \
    # libz-dev \
    # libpq-dev \
    # libjpeg-dev \
    # libpng-dev \
    # libfreetype6-dev \
    # libssl-dev \
    # libmcrypt-dev

# # Clean up
# RUN apt-get clean && \
#     rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
#     rm /var/log/lastlog /var/log/faillog

# # Install extensions
# RUN docker-php-ext-install pdo_mysql \
#   && docker-php-ext-configure gd \
#     --with-jpeg-dir=/usr/lib \
#     --with-png-dir=/usr/lib \
#     --with-freetype-dir=/usr/include/freetype2 && \
#     docker-php-ext-install gd

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN groupadd -g 1000 www
# RUN useradd -u 1000 -ms /bin/bash -g www www

# # Copy existing application directory contents
# COPY . /var/www

# # Copy existing application directory permissions
# COPY --chown=www:www . /var/www

# # Change current user to www
# USER www

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# # RUN chown -R www-data:www-data \
# #   /var/www/storage \
# #   /var/www/bootstrap/cache

# # RUN chgrp -R www-data /var/www/storage /var/www/bootstrap/cache && \
# #   chmod -R ug+rwx /var/www/storage /var/www/bootstrap/cache

# # Expose port 9000 and start php-fpm server
# CMD ["php-fpm"]

ENTRYPOINT ["/bin/bash"]
