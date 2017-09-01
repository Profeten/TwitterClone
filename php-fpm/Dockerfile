FROM php:7.1-fpm
MAINTAINER johan@pledger.se

# Install modules
RUN buildDeps="wget git unzip libpq-dev libzip-dev libicu-dev curl libpng-dev" && \
    apt-get update && \
    apt-get install -y $buildDeps --no-install-recommends && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install \
        pdo \
        #pdo_pgsql \
        #pgsql \
        sockets \
        intl \
        zip \
        && pecl install mongodb \
        && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/ext-mongodb.ini

# Installing nodejs and npm

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - && \
    apt-get install -y nodejs && \
    npm install npm@latest -g

# Install Composer.
ENV COMPOSER_HOME /root/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV PATH $COMPOSER_HOME/vendor/bin:$PATH
RUN wget https://phar.phpunit.de/phpunit-6.1.phar
RUN chmod +x phpunit-6.1.phar
RUN mv phpunit-6.1.phar /usr/local/bin/phpunit
RUN phpunit --version

# Installing redis

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

ENV TZ=Europe/Stockholm
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN usermod -u 1000 www-data

RUN mkdir /var/www/html/public

CMD ["php-fpm"]

EXPOSE 9000
