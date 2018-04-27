#!/bin/sh

now=$(date +"%Y-%m-%d-%H-%m-%s")

if [ "${MYSQL_PASSWORD}" ]; then
	/usr/bin/mysqldump --opt -h ${MYSQL_HOST} -u ${MYSQL_USER} -p"${MYSQL_PASSWORD}" ${MYSQL_DATABASE} > "/backup/${now}_${MYSQL_DATABASE}.sql"
else
        /usr/bin/mysqldump --opt -h ${MYSQL_HOST} -u ${MYSQL_USER} ${MYSQL_DATABASE} > "/backup/${now}_${MYSQL_DATABASE}.sql"
fi

