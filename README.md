# Songbook Installation Instructions #

## Add new user
`adduser jermin2`

### Add new user to sudo group
`usermod -aG sudo jermin2`

## Enable the firewall
`ufw enable`

### Remove other ports open
`ufw status numbered`
`ufw delete [rule number]`

## Install Composer
`sudo apt install php-cli unzip`
`cd ~`
`curl -sS https://getcomposer.org/installer -o composer-setup.php`

HASH=`curl -sS https://composer.github.io/installer.sig`

`php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"`

`sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer`

`apt-get install php-curl php-intl php-dom php-mbstring`

## Create docker directory ##
`mkdir docker`
`cd docker`

## Get Project ##
`git clone https://jermin2@bitbucket.org/jermin2/songbook-docker.git`

`cd songbook-docker`
`cd app`
`composer require codeigniter4/framework`
`composer install`

`cd ..`
`cd .docker`

### Set Permissions
`sudo docker exec -it songbook bash`
`-R www-data:www-data /var/www/html`

## Copy over SQL files
`sudo docker cp dump.sql songbook_db:`

### Run the sql file in mysql
`sudo docker exec -it songbook_db bash`
`mysql -u root -p`
[enter password]
`source dump.sql`