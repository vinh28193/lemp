#!/usr/bin/env bash

#== Import script args ==

github_token=$(echo "$1")

#== Bash helpers ==

function trace {
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

trace "Provision-script user: `whoami`"

trace "Installing PHP 7 and its components: [cli,common,fpm,curl,gd, intl,zip,xsl,mbstring,mysql]..."
apt-get install -y php7.0-cli
apt-get install -y php7.0-common
apt-get install -y php7.0
apt-get install -y php7.0-fpm
apt-get install -y php7.0-curl
apt-get install -y php7.0-gd
apt-get install -y php7.0-intl
apt-get install -y php7.0-zip
apt-get install -y php7.0-xsl
apt-get install -y php7.0-mbstring
apt-get install -y php7.0-mysql
# required by phpmyadmin
apt-get install -y php-gettext
# required for installing xdebug
apt-get install -y php7.0-dev

trace "Configuring PHP..."
sed -i 's/cgi.fix_pathinfo = cgi.fix_pathinfo = 0' | tee /etc/php/7.0/fpm/php.ini

trace "Installing Dnsmasq..."
apt-get install dnsmasq
echo "Pointing all *.dev domains to 127.0.0.1"
echo "address=/.dev/127.0.0.1" | tee /etc/dnsmasq.conf
sudo /etc/init.d/dnsmasq restart

trace "Restarting PHP, Nginx and MySQL services..."
sudo /etc/init.d/php7.0-fpm restart

trace "Installing MongoDB..."
apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv EA312927
echo "deb http://repo.mongodb.org/apt/ubuntu trusty/mongodb-org/3.2 multiverse" | tee /etc/apt/sources.list.d/mongodb-org-3.2.list
apt-get update
apt-get install -y --allow-unauthenticated mongodb-org
echo "[Unit]
Description=High-performance, schema-free document-oriented database
After=network.target
[Service]
User=mongodb
ExecStart=/usr/bin/mongod --quiet --config /etc/mongod.conf
[Install]
WantedBy=multi-user.target" | tee /etc/systemd/system/mongodb.service
sudo systemctl start mongodb
sudo systemctl status mongodb
sudo systemctl enable mongodb

trace "Installing Node.js"
apt-get install -y nodejs
ln -s /usr/bin/nodejs /usr/bin/node
apt-get install -y build-essential
apt-get install -y npm
ln -s /usr/bin/nodejs /usr/bin/node

trace "Installing Bower..."
npm install -g bower