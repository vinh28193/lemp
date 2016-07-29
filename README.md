Installation
============

## Requirements

The minimum requirement by this project template is that your Web server supports PHP 5.4.0.

## Installing using Vagrant

This way is the easiest but long (~20 min).

**This installation way doesn't require pre-installed software (such as web-server, PHP, MySQL etc.)** - just do next steps!

#### Manual for Linux/Unix users
1. Install [Git](https://git-scm.com/downloads)
2. Install [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
3. Install [Vagrant](https://www.vagrantup.com/downloads.html)
4. Create GitHub [personal API token](https://github.com/blog/1509-personal-api-tokens)
5. Prepare project:
   
   ```bash
   git clone https://github.com/vinh28193/whisnew.git
   cd whisnew/vagrant/config
   cp vagrant-local.example.yml vagrant-local.yml
   ```
   
6. Place your GitHub personal API token to `vagrant-local.yml`
7. Change directory to project root:

   ```bash
   cd whisnew
   ```

8. Run commands:

   ```bash
   vagrant plugin install vagrant-hostmanager
   vagrant up
   ```
   
That's all. You just need to wait for completion! After that you can access project locally by URLs:
* frontend: http://whisnew-frontend.dev
* backend: http://whisnew-backend.dev
* api: http://whisnew-api.dev

## Preparing application

  For Apache it could be the following:

   ```apache
       <VirtualHost *:80>
           ServerName whisnew-frontend.dev
           DocumentRoot "/path/to/whisnew/frontend/web/"
           
           <Directory "/path/to/whisnew/frontend/web/">
               # use mod_rewrite for pretty URL support
               RewriteEngine on
               # If a directory or a file exists, use the request directly
               RewriteCond %{REQUEST_FILENAME} !-f
               RewriteCond %{REQUEST_FILENAME} !-d
               # Otherwise forward the request to index.php
               RewriteRule . index.php

               # use index.php as index file
               DirectoryIndex index.php

               # ...other settings...
           </Directory>
       </VirtualHost>
       
       <VirtualHost *:80>
           ServerName whisnew-backend.dev
           DocumentRoot "/path/to/whisnew/backend/web/"
           
           <Directory "/path/to/whisnew/backend/web/">
               # use mod_rewrite for pretty URL support
               RewriteEngine on
               # If a directory or a file exists, use the request directly
               RewriteCond %{REQUEST_FILENAME} !-f
               RewriteCond %{REQUEST_FILENAME} !-d
               # Otherwise forward the request to index.php
               RewriteRule . index.php

               # use index.php as index file
               DirectoryIndex index.php

               # ...other settings...
           </Directory>
       </VirtualHost>

       <VirtualHost *:80>
           ServerName whisnew-api.dev
           DocumentRoot "/path/to/whisnew/api/web/"
           
           <Directory "/path/to/whisnew/api/web/">
               # use mod_rewrite for pretty URL support
               RewriteEngine on
               # If a directory or a file exists, use the request directly
               RewriteCond %{REQUEST_FILENAME} !-f
               RewriteCond %{REQUEST_FILENAME} !-d
               # Otherwise forward the request to index.php
               RewriteRule . index.php

               # use index.php as index file
               DirectoryIndex index.php

               # ...other settings...
           </Directory>
       </VirtualHost>
   ```

   For nginx:

   ```nginx
      server {
         charset utf-8;
         client_max_body_size 128M;

         listen 80; ## listen for ipv4
         #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

         server_name whisnew-frontend.dev;
         root        /app/frontend/web/;
         index       index.php;

         access_log  /app/vagrant/nginx/log/frontend-access.log;
         error_log   /app/vagrant/nginx/log/frontend-error.log;

         location / {
             # Redirect everything that isn't a real file to index.php
             try_files $uri $uri/ /index.php$is_args$args;
         }

         # uncomment to avoid processing of calls to non-existing static files by Yii
         #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
         #    try_files $uri =404;
         #}
         #error_page 404 /404.html;

         location ~ \.php$ {
             include fastcgi_params;
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
             #fastcgi_pass   127.0.0.1:9000;
             fastcgi_pass unix:/var/run/php5-fpm.sock;
             try_files $uri =404;
         }

         location ~ /\.(ht|svn|git) {
             deny all;
         }
      }

      server {
         charset utf-8;
         client_max_body_size 128M;

         listen 80; ## listen for ipv4
         #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

         server_name whisnew-backend.dev;
         root        /app/backend/web/;
         index       index.php;

         access_log  /app/vagrant/nginx/log/backend-access.log;
         error_log   /app/vagrant/nginx/log/backend-error.log;

         location / {
             # Redirect everything that isn't a real file to index.php
             try_files $uri $uri/ /index.php$is_args$args;
         }

         # uncomment to avoid processing of calls to non-existing static files by Yii
         #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
         #    try_files $uri =404;
         #}
         #error_page 404 /404.html;

         location ~ \.php$ {
             include fastcgi_params;
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
             #fastcgi_pass   127.0.0.1:9000;
             fastcgi_pass unix:/var/run/php5-fpm.sock;
             try_files $uri =404;
         }

         location ~ /\.(ht|svn|git) {
             deny all;
         }

      server {
         charset utf-8;
         client_max_body_size 128M;

         listen 80; ## listen for ipv4
         #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

         server_name whisnew-api.dev;
         root        /app/api/web/;
         index       index.php;

         access_log  /app/vagrant/nginx/log/api-access.log;
         error_log   /app/vagrant/nginx/log/api-error.log;

         location / {
             # Redirect everything that isn't a real file to index.php
             try_files $uri $uri/ /index.php$is_args$args;
         }

         # uncomment to avoid processing of calls to non-existing static files by Yii
         #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
         #    try_files $uri =404;
         #}
         #error_page 404 /404.html;

         location ~ \.php$ {
             include fastcgi_params;
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
             #fastcgi_pass   127.0.0.1:9000;
             fastcgi_pass unix:/var/run/php5-fpm.sock;
             try_files $uri =404;
         }

         location ~ /\.(ht|svn|git) {
             deny all;
         }
      }

   ```

5. Change the hosts file to point the domain to your server.

   - Windows: `c:\Windows\System32\Drivers\etc\hosts`
   - Linux: `/etc/hosts`

   Add the following lines:

   ```
   127.0.0.1   frontend.dev
   127.0.0.1   backend.dev
   ```

To login into the application, you need to first sign up, with any of your email address, username and password.
Then, you can login into the application with same email address and password at any time.


> Note: if you want to run advanced template on a single domain so `/` is frontend and `/admin` is backend, refer
> to [configs and docs by Oleg Belostotskiy](https://github.com/mickgeek/yii2-advanced-one-domain-config).