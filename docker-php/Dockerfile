# #php ใช้ version 7.1 สามารถเปลี่ยนได้ตามที่เราต้องการแต่ต้องเป็นตัว fpm นะครับ เพื่อที่จะให้กับ nginx
# FROM php:7.4-fpm

# #Install คำสั่งสำหรับการลง package ที่ laravel required ไว้นะครับ
# RUN apt-get update \
#     && apt-get install -y \
#     cron \
#     libfreetype6-dev \
#     libicu-dev \
#     libjpeg62-turbo-dev \
#     libmcrypt-dev \
#     libpng12-dev \
#     libxslt1-dev \
#     openssh-server \
#     openssh-client \
#     rsync

# RUN docker-php-ext-configure \
#     gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

# # ตามด้วยคำสั่งสำหรับการลง php extension ครับ
# RUN docker-php-ext-install \
#     bcmath \
#     gd \
#     intl \
#     mbstring \
#     mcrypt \
#     pdo_mysql \
#     soap \
#     xsl \
#     zip

# # อันนี้ลงเพิ่มเติมคือ composer นั้นเอง เป็นตัว package manager สำหรับการจัดการพวก dependency ของภาษา php ครับ
# RUN curl -sS https://getcomposer.org/installer | \
#     php -- --install-dir=/usr/local/bin --filename=composer

FROM php:7.4-fpm

# COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
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
    libonig-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-install gd
# RUN docker-php-ext-configure gd --with-gd --with-freetype --with-jpeg-

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www
RUN chown -R www-data:www-data /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
