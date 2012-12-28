#!/bin/sh


echo $1
echo $2
echo $3




while true

do 

$2 /var/www/TrainCompany/daemon.php > /dev/null;


sleep 1;

done 
