FROM php:8.1-fpm-alpine3.15

LABEL maintainer="Mirela Lisboa <mirela@cyberhound.io>"

RUN apk add --no-cache icu-dev oniguruma-dev shadow openssl \
    bash mysql-client nodejs npm git tzdata
RUN docker-php-ext-install pdo pdo_mysql

#RUN touch /root/.bashrc | echo "PS1='\w\$ '" >> /root/.bashrc
RUN touch /home/www-data/.bashrc | echo "PS1='\w\$ '" >> /home/www-data/.bashrc

ENV TZ=America/Sao_Paulo

COPY --from=composer:2.2.1 /usr/bin/composer /usr/local/bin/composer

COPY start-container /usr/local/bin/start-container
COPY php.ini /usr/local/etc/php-fpm.d/99-app.ini

RUN chmod +x /usr/local/bin/start-container

RUN usermod -u 1000 www-data

WORKDIR /var/www

RUN rm -rf /var/www/html

USER www-data

EXPOSE 9000

ENTRYPOINT ["start-container"]
