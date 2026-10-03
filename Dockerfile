FROM php:8.4-apache

# PHP extensions for MySQL (Aiven)
RUN docker-php-ext-install pdo pdo_mysql mysqli \
 && a2enmod rewrite headers

# Render gives us $PORT at runtime; default for local docker
ENV PORT=10000

# Apache: listen on $PORT, serve /public, send every request to index.php
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
 && printf '<VirtualHost *:${PORT}>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
        FallbackResource /index.php\n\
    </Directory>\n\
</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . /var/www/html

# LavaLust writes cache/logs here
RUN mkdir -p runtime && chown -R www-data:www-data runtime

EXPOSE 10000
CMD ["apache2-foreground"]
