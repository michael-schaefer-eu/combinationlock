FROM php:8-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY docker/php/conf.d/docker-php-phar.ini $PHP_INI_DIR/conf.d/docker-php-phar.ini

WORKDIR /srv/app

COPY composer.json ./
COPY build-phar.php ./
COPY src ./src/

RUN set -eux; \
	composer install --prefer-dist --no-scripts --no-progress --no-interaction; \
    composer clear-cache; \
    composer dump-autoload --classmap-authoritative; \
	php build-phar.php; \
	chmod +x combinationlock.phar

ENTRYPOINT ["tail", "-f", "/dev/null"]
