#!/bin/bash

# Update aptitude.
apt-get update

# Install PHP with necessary modules
apt-get -y install php5  php5-suhosin 
apt-get -y install php5-cli
apt-get -y install libapache2-mod-php5

# which creates a symbolic link /etc/apache2/mods-enabled/php5 pointing to /etc/apache2/mods-availble/php5 . 
a2enmod php5

# restart apache
/etc/init.d/apache2 restart

# Install Extras
apt-get -y install php5-curl php-pear php5-xdebug curl 
#php5-gd php5-gmp php5-imap php5-ldap php5-mcrypt php5-mhash php5-ming php5-odbc php5-pspell php5-snmp php5-sybase php5-tidy libwww-perl imagemagick

exit 0;