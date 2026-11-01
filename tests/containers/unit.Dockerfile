# Test container for the ChassisPHP framework.
# Uses real Composer dependencies so upgrades are tested against the actual libraries.
#
#   podman build --build-arg PHP_VERSION=7.4 -f tests/containers/unit.Dockerfile -t chassisphp:test-7.4 .
#   podman run --rm -v "$PWD":/src:ro,Z chassisphp:test-7.4
#
# or simply: tests/scripts/run-tests.sh 7.4

ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-cli-alpine

RUN apk add --no-cache git unzip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

# The source is mounted read-only at /src and copied in, so the host
# checkout never gets a vendor/ or composer.lock built for this PHP version.
CMD ["sh", "-c", "cp -a /src/. /app/ && rm -rf vendor composer.lock && composer update --no-interaction --no-progress --prefer-dist && composer test"]
