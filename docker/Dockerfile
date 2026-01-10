FROM php:8.2-fpm

# 1) Arguments pour aligner l’utilisateur du conteneur avec ton utilisateur local (évite les soucis de droits)
ARG USER_ID=1000
ARG GROUP_ID=1000

# 2) Installe les outils nécessaires + extensions PHP (PDO/MySQL, intl, zip)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) intl pdo pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 3) Recrée www-data avec le même UID/GID que sur ta machine
RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -u ${USER_ID} -g www-data -m www-data

# 4) Ajoute Composer dans l’image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5) Définit le dossier de travail et les droits
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html

# 6) Lance le conteneur avec www-data (pas en root)
USER www-data
