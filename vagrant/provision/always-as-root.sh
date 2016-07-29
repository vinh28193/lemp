#!/usr/bin/env bash

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

info "Restart web-stack"

info "Restart PHP5"
service php5-fpm restart
ensure "Done!"

info "Restart NGINX"
service nginx restart
ensure "Done!"

info "Restart MYSQL"
service mysql restart
ensure "Done!"