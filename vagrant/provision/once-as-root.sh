#!/usr/bin/env bash

#== Import script args ==

timezone=$(echo "$1")

#== Bash helpers ==

function info {
  echo " "
  echo "--> $1"
  echo " "
}

function ensure {
  echo " "
  echo "<-- $1"
  echo " "
}

#== Provision script ==

info "Provision-script user: `whoami`"

info "Allocate swap for MySQL 5.6"
fallocate -l 2048M /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap defaults 0 0' >> /etc/fstab
ensure "Done!"

info "Configure locales"
update-locale LC_ALL="C"
dpkg-reconfigure locales
ensure "Done!"

info "Configure timezone"
echo ${timezone} | tee /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata
ensure "Done!"

info "Prepare root password for MySQL"
debconf-set-selections <<< "mysql-server-5.6 mysql-server/root_password password \"''\""
debconf-set-selections <<< "mysql-server-5.6 mysql-server/root_password_again password \"''\""
ensure "Done!"

info "Update OS software"
apt-get update
apt-get upgrade -y
ensure "Done!"

info "Install additional software"
apt-get install -y git php5-curl php5-cli php5-intl php5-mysqlnd php5-gd php5-fpm nginx mysql-server-5.6
ensure "Done!"

info "Configure MySQL"
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf
ensure "Done!"

info "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php5/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php5/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php5/fpm/pool.d/www.conf
ensure "Done!"

info "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
ensure "Done!"

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
ensure "Done!"

info "Initailize databases for MySQL"
mysql -uroot <<< "CREATE DATABASE whisnew"
mysql -uroot <<< "CREATE DATABASE whisnew_tests"
ensure "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ensure "Done!"