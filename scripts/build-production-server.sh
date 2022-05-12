#!/bin/bash
# Author Emad Zaamout | support@ahtcloud.com

# Not used anywhere. Just helps install all what you need on your production server to run a basic laravel project. Run manually.

sudo apt update
sudo apt dist-upgrade
sudo apt install git unzip -y
sudo apt install apache2
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt install php7.4 -y
sudo apt install php7.4-curl php7.4-cli php7.4-mbstring php7.4-mysql php7.4-dom php7.4-xml php7.4-xmlwriter phpunit php7.4-xml php7.4-zip -y
sudo apt install libapache2-mod-php7.4
sudo a2dismod php8.0
sudo a2enmod php7.4
sudo /etc/init.d/apache2 restart

# install composer
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php
sudo php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/install
