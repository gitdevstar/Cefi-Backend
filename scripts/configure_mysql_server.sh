#!/bin/bash

sudo apt update
sudo apt-get install mysql-server -y

# Operation in mysql server
# sudo mysql

# CREATE DATABASE mynewdatabase;
# SHOW DATABASES;
# use DATABASES;

# Create new user
# CREATE USER 'myuser'@'localhost' IDENTIFIED BY 'mypassword';

# Grant user permission for DB
# GRANT ALL PRIVILEGES ON mynewdatabase.* TO 'myuser'@'localhost' WITH GRANT OPTION;
# FLUSH PRIVILEGES;


sudo service mysql status
