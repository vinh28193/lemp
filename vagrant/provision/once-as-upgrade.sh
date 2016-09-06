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
sudo apt-get install -y php7.0-cli
sudo apt-get install -y php7.0-common
sudo apt-get install -y php7.0
sudo apt-get install -y php7.0-fpm
sudo apt-get install -y php7.0-curl
sudo apt-get install -y php7.0-gd
sudo apt-get install -y php7.0-intl
sudo apt-get install -y php7.0-zip
sudo apt-get install -y php7.0-xsl
sudo apt-get install -y php7.0-mbstring
sudo apt-get install -y php7.0-mysql
# required by phpmyadmin
sudo apt-get install -y php-gettext
# required for installing xdebug
sudo apt-get install -y php7.0-dev

trace "Configuring PHP..."
sudo sed -i s/\;cgi\.fix_pathinfo\s*\=\s*1/cgi.fix_pathinfo\=0/ /etc/php/7.0/fpm/php.ini

trace "Installing Dnsmasq..."
sudo apt-get install dnsmasq
echo "Pointing all *.dev domains to 127.0.0.1"
echo "address=/.dev/127.0.0.1" >> /etc/dnsmasq.conf
sudo /etc/init.d/dnsmasq restart

trace "Restarting PHP, Nginx and MySQL services..."
sudo /etc/init.d/php7.0-fpm restart

trace "Installing MongoDB..."
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv EA312927
sudo echo "deb http://repo.mongodb.org/apt/ubuntu trusty/mongodb-org/3.2 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.2.list
sudo apt-get update
sudo apt-get install -y --allow-unauthenticated mongodb-org
sudo echo "[Unit]
Description=High-performance, schema-free document-oriented database
After=network.target
[Service]
User=mongodb
ExecStart=/usr/bin/mongod --quiet --config /etc/mongod.conf
[Install]
WantedBy=multi-user.target" >> /etc/systemd/system/mongodb.service
sudo systemctl start mongodb
sudo systemctl status mongodb
sudo systemctl enable mongodb

trace "Installing Node.js"
sudo apt-get install -y nodejs
sudo ln -s /usr/bin/nodejs /usr/bin/node
sudo apt-get install -y build-essential
sudo apt-get install -y npm
sudo ln -s /usr/bin/nodejs /usr/bin/node

trace "Installing Bower..."
sudo npm install -g bower