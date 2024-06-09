# use PHP 8.2
FROM php:8.2-fpm

# Install php extension dependencies & clear tmp
RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpq-dev \
    git \
    sudo \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-install zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql


# Set the working directory
COPY . /var/www/app/
WORKDIR /var/www/app/

# Modify access
RUN chmod -R 777 /var/www/app/

# Copy configs
COPY ./nginx/default.conf /etc/nginx/conf.d/
COPY ./php-ini/ /etc/php/conf.d/
COPY ./php-ini/ /usr/local/etc/php/

# PHP extensions
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Nodejs install
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# install composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# copy composer.json to workdir & install dependencies
COPY composer.json ./
RUN composer install

RUN npm run build
# RUN php artisan storage:link

# Set the default command to run php-fpm
CMD ["php-fpm"]