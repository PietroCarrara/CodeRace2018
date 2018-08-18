#!/bin/bash

# Frescura
Black='\033[0;30m'
Red='\033[0;31m'
Green='\033[0;32m'
Brown='\033[0;33m'
Blue='\033[0;34m'
Purple='\033[0;35m'
Cyan='\033[0;36m'
LightGray='\033[0;37m'
Clear='\033[0m'


if [ -f ./src/.env ]; then
    source ./src/.env
fi

usage() {
	echo "$0 [--host] [--help]"
	echo -e "\t--host:  roda o ambiente LAMP sem o PHPMyAdmin nem a docker bridge"
	echo -e "\t--build: compila a dockerfile e usa ela para o ambiente LAMP"
	echo -e "\t--clear: limpa o banco de dados (tabelas, usuários, databases...)"
	echo -e "\t--help:  mostra esse texto"
}

if [[ "$@" == *"--help"* ]]; then
	usage
	exit 0
fi

if [[ "$@" == *"--clear"* ]]; then
	echo -e "${Red}WARNING:${Clear} Você está prestes a limpar toda a base de dados. Seus dados ${Red}NÃO${Clear} poderão ser recuperados. Continuar? [s/N]"
	read conf
	if [[ $conf == s ]]; then
		echo "Limpando..."
		docker volume rm database
	fi
fi

host_mode=false
if [[ "$@" = *"--host"* ]]; then
	host_mode=true
fi

lamp_image='aufgfua/lamp:run'
if [[ "$@" = *"--build"* ]]; then
	lamp_image='tmp_lamp'
	if [[ $host_mode = true ]]; then
		docker build -t tmp_lamp --network=host .
	else
		docker build -t tmp_lamp .
	fi
fi

project=$(basename "$PWD" | tr '[:upper:]' '[:lower:]' | tr ' ' '_')

if [ -z "$MYSQL_PASSWORD" ]; then
	MYSQL_PASSWORD=password
fi

# Salvar o banco
docker volume create database

if [[ $host_mode == true ]]; then
	docker run --net=host --name "$project"_lamp --rm --mount 'source=database,target=/var/lib/mysql' -v "$PWD/src":/srv/http -e MYSQL_USER="$project" -e MYSQL_PASSWORD="$MYSQL_PASSWORD" -d "$lamp_image"
else
	docker run -p 3306:3306 -p 443:443 --name "$project"_lamp --rm --mount 'source=database,target=/var/lib/mysql' -v "$PWD/src":/srv/http -e MYSQL_USER="$project" -e MYSQL_PASSWORD="$MYSQL_PASSWORD" -d "$lamp_image"
    docker run --name "$project"_myadmin --rm --link "$project"_lamp:db -p 8000:80 -d phpmyadmin/phpmyadmin

fi


# Posso ser mt viajado, mas acho q precisa instalar com o composer

if [ ! -f '.comp' ]; then
    cd src
    composer install
    cd ..
    touch '.comp'
fi



echo -e "The project ${Red}$project${Clear} is beign run..."
echo -e "MySQL Username: ${Green}$project${Clear}"
echo -e "MySQL Password: ${Blue}$MYSQL_PASSWORD${Clear}"

echo -e "Press ${Purple}return${Clear} to stop docker..."

read nothing

docker kill "${project}_lamp"

if [[ $host_mode == false ]]; then
	docker kill "${project}_myadmin"
fi

