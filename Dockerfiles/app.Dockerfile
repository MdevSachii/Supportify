FROM php:8.3.7-fpm-alpine3.19
ARG UID
RUN apk --update add shadow sudo composer make \
    php-session php-tokenizer php-xml php-dom php-xmlwriter php-fileinfo \
    nodejs npm \
    && docker-php-ext-install pdo_mysql
RUN usermod -u $UID www-data && groupmod -g $UID www-data \
    && echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers
    