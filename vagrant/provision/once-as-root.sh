#!/usr/bin/env bash

#== Import script args ==

timezone=$(echo "$1")

#== Bash helpers ==

function trace {
  echo " "
  echo "==> $1"
  echo " "
}

function ensure {
  echo " "
  echo "<== $1"
  echo " "
}

#== Provision script ==

trace "Provision-script user: `whoami`"

trace "Allocate swap for MySQL 5.6"
fallocate -l 2048M /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap defaults 0 0' >> /etc/fstab
ensure "Done!"

trace "Configure locales"
update-locale LC_ALL="C"
dpkg-reconfigure locales
ensure "Done!"

trace "Configure timezone"
echo ${timezone} | tee /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata
ensure "Done!"

trace "Prepare root password for MySQL"
debconf-set-selections <<< "mysql-server-5.6 mysql-server/root_password password \"''\""
debconf-set-selections <<< "mysql-server-5.6 mysql-server/root_password_again password \"''\""
ensure "Done!"

trace "Update OS software"
apt-get update
apt-get upgrade -y
ensure "Done!"

trace "Install Git"
apt-get install -y git
ensure "Done!"

trace "Install Php5"
apt-get install -y php5-curl
apt-get install -y php5-cli
apt-get install -y php5-intl 
apt-get install -y php5-mysqlnd 
apt-get install -y php5-gd
apt-get install -y php5-fpm
ensure "Done!"

trace "Install NGINX"
apt-get install -y nginx
ensure "Done!"

trace "Install MySQL"
apt-get install -y mysql-server-5.6
ensure "Done!"

trace "Configure MySQL"
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf
ensure "Done!"

trace "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php5/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php5/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php5/fpm/pool.d/www.conf
ensure "Done!"

trace "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
ensure "Done!"

trace "Initailize databases for MySQL"
mysql -uroot <<< "CREATE DATABASE whisnew"
mysql -uroot <<< "CREATE DATABASE whisnew_tests"
ensure "Done!"

trace "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ensure "Done!"