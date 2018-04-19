## Install and configure web application

- Copy the github [www folder content](/srv/www/home.fr/public/) under /srv/www/home.fr/public/
> sudo chown -R pi:www-data /srv/www<br>
> sudo chmod -R 755 /srv/www<br>
> chmod 664/srv/www/home.fr/public/conf/cron.txt<br>
- Install the crontab (as such it also will remain after a reboot)
>sh /srv/www/home.fr/public/conf/cron.sh<br>
- Define you playlist 
> sudo nano /srv/www/home.fr/public/conf/station.txt<br>
````
1 http://stream1.chantefrance.com/stream_chante_france.mp3 #Chante France
0 http://cdn.nrjaudio.fm/audio1/fr/30001/mp3_128.mp3?origine=fluxradios #NRJ
0 http://cdn.nrjaudio.fm/audio1/fr/30601/mp3_128.mp3?origine=fluxradios #Nostalgie
0 http://cdn.nrjaudio.fm/audio1/fr/30201/mp3_128.mp3?origine=fluxradios #Cherie FM
0 http://roo8ohho.cdn.dvmr.fr/live/franceinfo-midfi.mp3?ID=f9fbk29m84 #France Info
0 http://icepe2.infomaniak.ch/impactfm-128.mp3 #Impact FM
0 http://radioclassique.ice.infomaniak.ch/radioclassique-high.mp3 #Radio Classique
````
File structure is "favorite \<space> radio_stream_url \<space> #radio_nickname"

favorite = 1 for only one station (the one that will be started when radio is put ON)

Note: with the app, you can change it later at your convenience
> chmod 664/srv/www/home.fr/public/conf/station.txt<br>

- Define default settings of the application
> sudo nano /srv/www/home.fr/public/conf/config.php
````
<?php
$config = [
	//"web" => ["base_url" => ""],
	"layout_title" => ["title" => "Satellite Audio 1"],
	"tts" => [ "voiceRSSkey" => '#your VoiceRSS API key#',
				"vol" => 70,
				"localTTS" => true,
				"weatherUrl" => 'https://www.prevision-meteo.ch/services/json/#your city name#',
				"jeedomUrl" => 'http://192.168.1.108/core/api/jeeApi.php?apikey=#your Jeedom API key#&type=interact&query=#your interaction query#'],
	"cron" => [ "path" => '/srv/www/home.fr/public/conf/cron.txt'],
	"station" => [ "path" => '/srv/www/home.fr/public/station/station.txt',
					"local" => '/srv/www/home.fr/public/conf/clocher-x12-SF.mp3',
					"default" => 'http://stream1.chantefrance.com/stream_chante_france.mp3'],
					"snooze" => [ "delay" => '+5 minutes']
];
````


