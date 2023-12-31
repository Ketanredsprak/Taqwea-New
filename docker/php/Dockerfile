ARG PHP_VERSION="latest"
FROM php:${PHP_VERSION}-fpm

ARG NODE_VERSION="latest"

#Node configuration
RUN curl -sL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash -

# Install dependencies
RUN apt-get update && apt-get install -y -o 'Acquire::Retries=3' \
    build-essential \
    libc-client-dev \
    libonig-dev \
    libcurl4-gnutls-dev \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libmemcached-dev \
    libsnmp-dev \
    libssl-dev  \
    libtasn1-6-dev \
    libtidy-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    git \
    zip \
    unzip \
    vim \
    curl \
    cron \
    nodejs \
    supervisor
    

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/


#  Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd pdo_mysql exif memcached mysqli opcache curl intl imap mcrypt memcache pspell imagick redis sockets mbstring

RUN install-php-extensions zip 

# Supervisor configuration
RUN mkdir -p /var/log/supervisor
COPY ./docker/php/app-queue.conf /etc/supervisor/conf.d/app-queue.conf

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000

# Set working directory
WORKDIR /var/www/html

ENTRYPOINT ["./docker/php/start.sh"]

CMD ["php-fpm"]
