FROM khanhicetea/php7-fpm-docker

RUN apt-get -y update && apt-get install -y supervisor nodejs npm apache2 curl

RUN curl -sS http://dl.yarnpkg.com/debian/pubkey.gpg |  apt-key add -
RUN echo "deb http://dl.yarnpkg.com/debian/ stable main" |  tee /etc/apt/sources.list.d/yarn.list

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -

RUN apt-get -y update && apt-get -y install nodejs yarn libapache2-mod-php7.1 && apt-get -y upgrade

RUN a2enmod  php7.1
RUN a2enmod  rewrite
RUN a2enconf php7.1-fpm

COPY docker/apache/sites-available/* /etc/apache2/sites-available/

RUN curl -LO https://deployer.org/deployer.phar && mv deployer.phar /usr/local/bin/dep && chmod +x /usr/local/bin/dep

#RUN useradd -d /home/app -m app
#RUN adduser app www-data

COPY . /var/www/html/pgr
RUN chown -R www-data:www-data /var/www/html/pgr
COPY docker/supervisor/conf.d/* /etc/supervisor/conf.d/

WORKDIR /var/www/html/pgr

RUN composer install
RUN yarn
RUN yarn run production

RUN chown -R www-data:www-data /var/www/html/pgr

EXPOSE 8080

#CMD 'php artisan serve --port=8080 --host=0.0.0.0'

#USER root
CMD "/usr/bin/supervisord"
