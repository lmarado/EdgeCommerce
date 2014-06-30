#!/bin/sh

echo "Please provide the user who should have privileges on group www-data (default: ${USER}): "
read USERNAME
if [ -z "${USERNAME}" ]; then
	USERNAME=${USER}
fi
echo "Please define the virtual host (default: magento-dev.pt): "
read SITE
if [ -z "${SITE}" ]; then
	SITE="magento-dev.pt"
fi

echo "Installing pre-requirements"

sudo apt-get update
sudo apt-get install apache2
sudo apt-get install php5 php5-curl php5-gd php5-mcrypt php5-mysql
sudo apt-get install mysql-server

echo "Adding user permissions"

sudo usermod -a -G www-data $USERNAME

echo "Creating site folder and setting basic permissions"

sudo mkdir -p "/var/www/${SITE}/public"
sudo mkdir -p "/var/www/${SITE}/log"
sudo chgrp www-data -R "/var/www/${SITE}"
sudo chmod 2750 "/var/www/${SITE}/public"

echo "Configuring Apache Virtual Host"

sudo bash -c "cat >> /etc/apache2/sites-available/${SITE}.conf <<EOF
<VirtualHost *:80>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host (this file) this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        ServerName ${SITE}
        ServerAlias www.${SITE}

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/${SITE}/public

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        ErrorLog \${APACHE_LOG_DIR}/error.log
        CustomLog \${APACHE_LOG_DIR}/access.log combined

        # For most configuration files from conf-available/, which are
        # enabled or disabled at a global level, it is possible to
        # include a line for only one particular virtual host. For example the
        # following line enables the CGI configuration for this host only
        # after it has been globally disabled with \"a2disconf\".
        #Include conf-available/serve-cgi-bin.conf
</VirtualHost>
EOF"

sudo a2ensite ${SITE}
sudo service apache2 restart

sed -i "s/\tlocalhost/\tlocalhost www.${SITE} ${SITE}/" /etc/hosts

echo "Testing hosts"
echo "\nTesting www.${SITE}\n"
curl www.${SITE}
echo "\nTesting ${SITE}\n"
curl ${SITE}

echo "\nPlease input the root password for MySQL (default: root): "
read MYSQLPASS
if [ -z "${MYSQLPASS}" ]; then
        MYSQLPASS="root"
fi

mysql -uroot -p${MYSQLPASS} <<QUERIES
CREATE DATABASE magento;
INSERT INTO mysql.user (User,Host,Password) VALUES('magento','localhost',PASSWORD('magento'));
FLUSH PRIVILEGES;
GRANT ALL PRIVILEGES ON magento.* TO magento@localhost;
FLUSH PRIVILEGES;
QUERIES

echo "Downloading Magento and deploying on WebServer"

wget http://www.magentocommerce.com/downloads/assets/1.9.0.1/magento-1.9.0.1.zip
unzip magento-1.9.0.1.zip -d /var/www/${SITE}/public
mv /var/www/${SITE}/public/magento/* /var/www/${SITE}/public/magento/.htaccess /var/www/${SITE}/public
rm magento-1.9.0.1.zip

echo "Adding extra permissions"
sudo chmod g+w /var/www/${SITE}/public/var /var/www/${SITE}/public/var/.htaccess /var/www/${SITE}/public/app/etc
sudo chmod -R g+w /var/www/${SITE}/public/var/package /var/www/${SITE}/public/media

echo "Setting mcrypt"
sed -i "/\[mcrypt\]/a extension=mcrypt\.so" /etc/php5/apache2/php.ini

echo "Access www.${SITE} and complete the installation process"
exit;
