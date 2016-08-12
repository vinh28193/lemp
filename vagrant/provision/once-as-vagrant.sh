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

trace "Configure composer"
composer config --global github-oauth.github.com ${github_token}
ensure "Done!"

trace "Install plugins for composer"
composer global require "fxp/composer-asset-plugin:~1.1.1" --no-progress

trace "Install codeception"
composer global require "codeception/codeception=2.0.*" "codeception/specify=*" "codeception/verify=*" --no-progress
echo 'export PATH=/home/vagrant/.config/composer/vendor/bin:$PATH' | tee -a /home/vagrant/.profile
ensure "Done!"

trace "Install project dependencies"
cd /app
composer --no-progress --prefer-dist install
ensure "Done!"

trace "Init project"
php ./init --env=Development --overwrite=y
ensure "Done!"

trace "Apply migrations"
php ./yii migrate <<< "yes"
ensure "Done!"

trace "Create bash-alias 'app' for vagrant user"
echo 'alias app="cd /app"' | tee /home/vagrant/.bash_aliases
ensure "Done!"

trace "Enabling colorized prompt for guest console"
sed -i "s/#force_color_prompt=yes/force_color_prompt=yes/" /home/vagrant/.bashrc
ensure "Done!"