#FROM khanhicetea/php7-fpm-docker
FROM ubuntu:16.04

ARG VERSION=latest
ARG BUILD_DATE=unknown
ARG SOURCE_COMMIT=HEAD  

ENV DEBIAN_FRONTEND noninteractive


RUN apt-get clean && apt-get -y update && apt-get install -y locales curl software-properties-common git \
  && locale-gen en_US.UTF-8 
RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php

RUN curl -sS http://dl.yarnpkg.com/debian/pubkey.gpg |  apt-key add -
RUN echo "deb http://dl.yarnpkg.com/debian/ stable main" |  tee /etc/apt/sources.list.d/yarn.list
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -

RUN curl -o /usr/local/bin/rmate https://raw.githubusercontent.com/aurora/rmate/v1.0.1/rmate && chmod +x /usr/local/bin/rmate

RUN apt-get -y update && apt-get -y --force-yes upgrade && \
    apt-get install -y --force-yes php7.3-bcmath php7.3-bz2 php7.3-cli php7.3-common php7.3-curl \
                php7.3-cgi php7.3-dev php7.3-fpm php7.3-gd php7.3-gmp php7.3-imap php7.3-intl \
                php7.3-json php7.3-ldap php7.3-mbstring php7.3-mysql \
                php7.3-odbc php7.3-opcache php7.3-pgsql php7.3-phpdbg php7.3-pspell \
                php7.3-readline php7.3-recode php7.3-soap php7.3-sqlite3 \
                php7.3-tidy php7.3-xml php7.3-xmlrpc php7.3-xsl php7.3-zip \
                php-tideways php-mongodb \
                vim nano supervisor nodejs duplicity \
                yarn apache2 apache2-utils libapache2-mod-php7.3 \
                && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


RUN a2enmod  php7.3 && a2enmod rewrite && a2enconf php7.3-fpm
RUN /usr/sbin/update-alternatives --set php /usr/bin/php7.3 && /usr/sbin/update-alternatives --set phar /usr/bin/phar7.3

RUN curl -LO https://deployer.org/deployer.phar && mv deployer.phar /usr/local/bin/dep && chmod +x /usr/local/bin/dep
RUN curl -L https://getcomposer.org/installer > composer-setup.php && php composer-setup.php && mv composer.phar /usr/local/bin/composer && rm composer-setup.php


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

RUN composer install
RUN yarn
RUN yarn run production

RUN chown -R www-data:www-data /var/www/html/pgr

EXPOSE 8080

#CMD 'php artisan serve --port=8080 --host=0.0.0.0'

ENV APP_VERSION=$VERSION
ENV BUILD_DATE=$BUILD_DATE
ENV GIT_COMMIT_HASH=$SOURCE_COMMIT

#USER root
CMD "/usr/bin/supervisord"
