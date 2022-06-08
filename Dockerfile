FROM composer as composer
WORKDIR /app
COPY composer.json .
COPY composer.lock .
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs
COPY . .

FROM php:8.1-fpm-alpine
RUN echo "UTC" > /etc/timezone
RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 1024M;" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 1024M;" >> /usr/local/etc/php/conf.d/uploads.ini
WORKDIR /var/www/html
COPY --from=composer /app .
ENTRYPOINT ["/bin/sh","-c","php -S 0.0.0.0:80 -t ./public"]