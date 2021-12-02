FROM php:8.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip \
#     python \
#     librdkafka-dev 
    # php8.0-dev \ 
    # php-pear

    # Packages
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        git \
        zlib1g-dev \
        unzip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        curl \
        python \
        && ( \
            cd /tmp \
            && mkdir librdkafka \
            && cd librdkafka \
            && git clone https://github.com/edenhill/librdkafka.git . \
            && ./configure \
            && make \
            && make install \
        ) 
        # \
    # && rm -r /var/lib/apt/lists/*

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) zip \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka


RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd sockets
 
# KAFKA


# RUN pecl channel-update pecl.php.net \
#     && pecl install rdkafka-$EXT_RDKAFKA_VERSION \
#     && docker-php-ext-enable rdkafka \
#     && rm -rf /librdkafka \
#     && apk del $BUILD_DEPS

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*



# Install PHP extensions
# RUN docker-php-ext-install 

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


WORKDIR /var/www


USER $user
