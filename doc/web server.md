## Nginx web server configuration

>sudo service nginx start

from here, [http://IP of your audio satellite](http://IP_of_your_audio_satellite) should show a welcome page
- Create www root structure and configure php FastCGI Process Manager
>sudo service php7.0-fpm restart<br>
>sudo mkdir /srv/www<br>
>mkdir /srv/www/home.fr<br>
>cd /srv/www/home.fr<br>
>mkdir logs<br>
>touch logs/access.log<br>
>touch logs/error.log<br>
> mkdir public<br>
> sudo chown -R pi:www-data /srv/www<br>
> sudo chmod -R 755 /srv/www<br>
> cd /home/pi<br>
> sudo ln -s  /srv/www www<br>
> sudo nano /etc/nginx/sites-available/home.fr<br>
````
server {
	server_name home.fr ##your IP##;
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
		fastcgi_param SCRIPT_FILENAME /srv/www/home/public$fastcgi_script_name;
	}
}
````

>sudo ln -s /etc/nginx/sites-available/home.fr /etc/nginx/sites-enabled/home.fr<br>
>sudo service nginx restart<br>
- Add www-data in audio group
>sudo usermod -a -G audio www-data<br>


