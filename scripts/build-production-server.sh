#!/bin/bash
# Author Emad Zaamout | support@ahtcloud.com

# Not used anywhere. Just helps install all what you need on your production server to run a basic laravel project. Run manually.

sudo apt update
sudo apt dist-upgrade
sudo apt install apache2
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt install php7.4
sudo apt install php-curl php-cli php-mbstring git unzip php7.4-mysql php7.4-dom php7.4-xml php7.4-xmlwriter phpunit php-mbstring php-xml
sudo apt install libapache2-mod-php7.4
sudo a2enmod rewrite
sudo /etc/init.d/apache2 restart

# install composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/install
