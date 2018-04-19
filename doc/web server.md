## Nginx web server configuration

>sudo service nginx start

from here, [http://#your IP#](http://#your IP#) should show a welcome page
>sudo service php7.0-fpm restart
>sudo mkdir /srv/www
>mkdir /srv/www/home.fr
>cd /srv/www/home.fr
>mkdir logs
>touch logs/access.log
>touch logs/error.log
> mkdir public
> sudo chown -R pi:www-data /srv/www
> sudo chmod -R 755 /srv/www
> cd /home/pi
> sudo ln -s  /srv/www www
> sudo nano /etc/nginx/sites-available/home.fr
````
server {
	server_name home.fr 192.168.1.117;
	access_log /srv/www/home.fr/logs/access.log;
	error_log /srv/www/home.fr/logs/error.log;
	root /srv/www/home.fr/public/;

	location / {
		index index.php index.html index.htm;
		try_files $uri $uri/ /index.php?$args;
	}

	location ~ \.php$ {
		include /etc/nginx/fastcgi_params;
		fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
		fastcgi_index index.php;
		fastcgi_param SCRIPT_FILENAME /srv/www/home/public
		$fastcgi_script_name;
	}
}
````


