FROM php:8.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid


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

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) zip \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Install PHP extensions and setup pgsql
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd sockets
 
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


WORKDIR /var/www


USER $user
