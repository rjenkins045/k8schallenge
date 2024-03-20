FROM php:7.4-apache
WORKDIR /app
COPY . /var/www/html/
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
ENV DB_HOST=mysql-service
ENV DB_USER=mariadb-user-creds
ENV DB_PASSWORD=mariadb-user-creds
ENV DB_NAME=ecomdb
ENV DB_PORT=3306
EXPOSE 80