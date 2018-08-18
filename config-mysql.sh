#!/bin/bash

# Wait for mysql
while [[ $(mysqladmin ping --silent) != "mysqld is alive" ]]; do
	printf .
	lf=$'\n'
	sleep 1
done
printf "$lf"

if [ "$MYSQL_USER" ] && [ "$MYSQL_PASSWORD" ]; then
	mysql -uadmin -u root "GRANT ALL PRIVILEGES ON *.* TO '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD'";
	# mysql -uadmin -u root -e "DELETE FROM mysql.user WHERE user != '$MYSQL_USER'"
	mysql -uadmin -u root -e "FLUSH PRIVILEGES"
	mysql -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" -e "CREATE DATABASE $MYSQL_USER"
	mysql -u -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" -e "DELETE FROM mysql.user WHERE user != '$MYSQL_USER'"
else
	echo "Fail"
	exit 1
fi

