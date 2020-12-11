FROM debian

# Install PHP 8
RUN apt-get update -y; \
    apt-get -y install lsb-release apt-transport-https ca-certificates wget; \
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg; \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list; \
    apt-get update -y; \
    apt-get install php8.0 -y;

# Install PHP Extensions
RUN apt-get -y install php8.0-xml; \
    apt-get -y install php8.0-mbstring; \
    apt-get -y install php8.0-zip; \
    apt-get -y install php8.0-xdebug; \
    apt-get -y install zip; \
    apt-get -y install unzip;

# Install git, needed by some composer dependencies
RUN apt-get -y install git-all

# Install composer
RUN echo '- Installing composer ...' && \
    EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"; \
    [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ] && { >&2 echo 'ERROR: Invalid installer signature'; exit 1; }; \
    php composer-setup.php --quiet --install-dir=/bin --filename=composer && \
    composer --version && \
    rm composer-setup.php;


COPY . /app

WORKDIR /app
