# tests/containers/unit.Dockerfile
# Minimal container for framework unit tests (no external dependencies)

FROM php:8.1-cli-alpine

LABEL maintainer="ChassisPHP Team"
LABEL description="Unit testing container for ChassisPHP Framework"

# Install minimal system dependencies including oniguruma for mbstring
RUN apk add --no-cache \
    git \
    unzip \
    oniguruma-dev

# Install only essential PHP extensions
RUN docker-php-ext-install mbstring

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create app directory
WORKDIR /app

# Create app directory
WORKDIR /app

# Create non-root user for security
RUN adduser -D -s /bin/sh phpuser

# Install PHPUnit in a location that won't be overwritten
RUN mkdir -p /opt/phpunit
WORKDIR /opt/phpunit

# Create a minimal composer.json just for PHPUnit (back to PHPUnit 8)
RUN echo '{"require-dev":{"phpunit/phpunit":"^8.0"},"config":{"allow-plugins":{"*":true}}}' > composer.json

# Install only PHPUnit (no framework dependencies)
RUN composer install --dev --no-scripts

# Verify PHPUnit was installed
RUN ls -la vendor/bin/ && ./vendor/bin/phpunit --version

# Switch back to /app for the actual framework code
WORKDIR /app
RUN chown phpuser:phpuser /app
USER phpuser

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD php -v || exit 1

# Default command runs unit tests with minimal bootstrap
CMD ["/opt/phpunit/vendor/bin/phpunit", "--testsuite=ChassisPHP Unit Tests", "--bootstrap=tests/bootstrap-minimal.php", "--colors=always"]