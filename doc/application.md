## Install and configure web application

- Copy the github [www folder content](/srv/www/home.fr/public/) under /srv/www/home.fr/public/
> sudo chown -R pi:www-data /srv/www<br>
> sudo chmod -R 755 /srv/www<br>
> chmod 664/srv/www/home.fr/public/conf/cron.txt<br>
- Install the crontab (as such it also will remain after a reboot)
>sh /srv/www/home.fr/public/conf/cron.sh


