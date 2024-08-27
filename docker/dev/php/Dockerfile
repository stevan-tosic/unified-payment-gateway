FROM php:8.3-cli-alpine3.20

ARG APP_ENV
ARG USER_ID

# SYS: Install required packages
RUN apk --no-cache upgrade && \
    apk --no-cache add bash boost-dev git sudo gcc g++ make nodejs npm autoconf openssh shadow vim \
    icu icu-data-full openssl-dev pcre-dev icu-dev libzip-dev curl-dev linux-headers

# NODE: install nodemon
RUN npm install -g nodemon

RUN if [ -n "$USER_ID" ] && [ "$USER_ID" -lt 60001 ]; then \
        usermod -u ${USER_ID} -o www-data; \
    fi

# USER: set /bin/bash and allow www-data to become root
RUN usermod -s /bin/bash www-data && \
    echo 'www-data ALL=(ALL) NOPASSWD: ALL' > '/etc/sudoers.d/www-data'

# USER: copy home
COPY --chown=www-data:www-data dev/php/files/user-home /home/www-data

# USER: add ssh key and fix permission of the ssh directory
RUN ln -s /run/secrets/ssh_host_key /home/www-data/.ssh/id_rsa && \
    chmod 700 /home/www-data/.ssh && \
    chmod 400 /home/www-data/.ssh/config

# Permissions
RUN chmod 777 /tmp

# PHP: Copy configuration files & remove dist files
COPY dev/php/files/php/ /phpIni
COPY dev/php/files/bin/ /usr/local/bin/

# COMPOSER: install binary
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# PHP: Install php extensions
RUN pecl channel-update pecl.php.net && \
    MAKEFLAGS=-j$(nproc) pecl install apcu pcov xdebug && \
    docker-php-ext-install -j$(nproc) intl pcntl pdo_mysql zip && \
    php-ext-enable intl pcntl apcu opcache pdo_mysql zip pcov xdebug

# PHP: Copy configuration files & remove dist files
COPY dev/php/files/startup.sh /usr/bin/startup.sh
RUN chmod +x /usr/bin/startup.sh

# LOG && Permissions
RUN chmod 777 /tmp

USER www-data

WORKDIR /var/www/html

# ENTRYPOINT
ENTRYPOINT ["/usr/bin/startup.sh"]
