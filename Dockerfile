FROM ubuntu:16.04

ARG VERSION=latest
ARG BUILD_DATE=unknown
ARG SOURCE_COMMIT=HEAD

ENV DEBIAN_FRONTEND noninteractive
ENV IMAGE_PHP_VERSION 7.3


RUN apt-get clean && apt-get -y update && apt-get install -y locales curl software-properties-common git \
  && locale-gen en_US.UTF-8 
RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php

RUN curl -sS http://dl.yarnpkg.com/debian/pubkey.gpg |  apt-key add -
RUN echo "deb http://dl.yarnpkg.com/debian/ stable main" |  tee /etc/apt/sources.list.d/yarn.list
RUN curl -sL https://deb.nodesource.com/setup_13.x | bash -

RUN curl -o /usr/local/bin/rmate https://raw.githubusercontent.com/aurora/rmate/v1.0.1/rmate && chmod +x /usr/local/bin/rmate

RUN apt-get -y update && apt-get -y --force-yes upgrade && \
    apt-get install -y --force-yes php${IMAGE_PHP_VERSION}-bcmath php${IMAGE_PHP_VERSION}-bz2 php${IMAGE_PHP_VERSION}-cli php${IMAGE_PHP_VERSION}-common php${IMAGE_PHP_VERSION}-curl \
                php${IMAGE_PHP_VERSION}-cgi php${IMAGE_PHP_VERSION}-dev php${IMAGE_PHP_VERSION}-fpm php${IMAGE_PHP_VERSION}-gd php${IMAGE_PHP_VERSION}-gmp php${IMAGE_PHP_VERSION}-imap php${IMAGE_PHP_VERSION}-intl \
                php${IMAGE_PHP_VERSION}-json php${IMAGE_PHP_VERSION}-ldap php${IMAGE_PHP_VERSION}-mbstring php${IMAGE_PHP_VERSION}-mysql \
                php${IMAGE_PHP_VERSION}-odbc php${IMAGE_PHP_VERSION}-opcache php${IMAGE_PHP_VERSION}-pgsql php${IMAGE_PHP_VERSION}-phpdbg php${IMAGE_PHP_VERSION}-pspell \
                php${IMAGE_PHP_VERSION}-readline php${IMAGE_PHP_VERSION}-recode php${IMAGE_PHP_VERSION}-soap php${IMAGE_PHP_VERSION}-sqlite3 \
                php${IMAGE_PHP_VERSION}-tidy php${IMAGE_PHP_VERSION}-xml php${IMAGE_PHP_VERSION}-xmlrpc php${IMAGE_PHP_VERSION}-xsl php${IMAGE_PHP_VERSION}-zip \
                php-tideways php-mongodb \
                vim nano supervisor nodejs duplicity zip unzip \
                yarn apache2 apache2-utils libapache2-mod-php${IMAGE_PHP_VERSION} \
                && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


RUN a2enmod  php${IMAGE_PHP_VERSION} && a2enmod rewrite && a2enconf php${IMAGE_PHP_VERSION}-fpm
RUN /usr/sbin/update-alternatives --set php /usr/bin/php${IMAGE_PHP_VERSION} && /usr/sbin/update-alternatives --set phar /usr/bin/phar${IMAGE_PHP_VERSION}

# RUN curl -LO https://deployer.org/deployer.phar && mv deployer.phar /usr/local/bin/dep && chmod +x /usr/local/bin/dep
# RUN curl -L https://getcomposer.org/installer > composer-setup.php && php composer-setup.php && mv composer.phar /usr/local/bin/composer && rm composer-setup.php


COPY docker/apache/sites-available/* /etc/apache2/sites-available/
COPY docker/apache/mysitename.crt /etc/apache2
COPY docker/apache/mysitename.key /etc/apache2
RUN chmod 600 /etc/apache2/mysite*
COPY docker/cron/crontab /root/crontab
RUN crontab -u www-data /root/crontab

#RUN useradd -d /home/app -m app
#RUN adduser app www-data


COPY . /var/www/html/pgr
RUN chown -R www-data:www-data /var/www/html/pgr
COPY docker/supervisor/conf.d/* /etc/supervisor/conf.d/
RUN a2enmod ssl

WORKDIR /var/www/html/pgr

# RUN composer install
# RUN yarn
# RUN yarn run production

RUN chown -R www-data:www-data /var/www/html/pgr

EXPOSE 8080

#CMD 'php artisan serve --port=8080 --host=0.0.0.0'

ENV APP_VERSION=$VERSION
ENV BUILD_DATE=$BUILD_DATE
ENV GIT_COMMIT_HASH=$SOURCE_COMMIT

#USER root
CMD "/usr/bin/supervisord"
