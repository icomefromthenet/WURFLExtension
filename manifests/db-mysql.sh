#!/bin/bash

# Update aptitude.
apt-get update

# Install MySQL.

apt-get install expect

VAR=$(expect -c '
spawn apt-get -y install mysql-server
expect "New password for the MySQL \"root\" user:"
send "vagrant\r"
expect "Repeat password for the MySQL \"root\" user:"
send "vagrant\r"
expect eof
')

echo "$VAR"

apt-get -y install php5-mysql 

#apt-get -y install mysql-client

exit 0;