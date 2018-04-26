## Install and configure web application

- Copy the github [www folder content](https://github.com/diving91/web-radio/tree/master/www) under /srv/www/home.fr/public/
> sudo chown -R pi:www-data /srv/www<br>
> sudo chmod -R 755 /srv/www<br>
> chmod 664/srv/www/home.fr/public/conf/cron.txt<br>
- Install the crontab (as such it also will remain after a reboot)
>sh /srv/www/home.fr/public/conf/cron.sh<br>
- Define your playlist 
> sudo nano /srv/www/home.fr/public/station/station.txt<br>
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

Note: with the  web app, you can change it later at your convenience
> chmod 664/srv/www/home.fr/public/station/station.txt<br>

- Define default settings of the application
> sudo nano /srv/www/home.fr/public/conf/config.php
```php
<?php
$config = [
	//"web" => ["base_url" => ""],
	"layout_title" => ["title" => "Satellite Audio 1"],
	"tts" => [ "voiceRSSkey" => '#your VoiceRSS API key#',
		"vol" => 70,
		"localTTS" => true,
		"weatherUrl" => 'https://www.prevision-meteo.ch/services/json/#your city name#',
		"jeedomUrl" => 'http://#your jeedom IP#/core/api/jeeApi.php?apikey=#your Jeedom API key#&type=interact&query=#your interaction query#'],
	"cron" => [ "path" => '/srv/www/home.fr/public/conf/cron.txt'],
	"station" => [ "path" => '/srv/www/home.fr/public/station/station.txt',
			"local" => '/srv/www/home.fr/public/conf/clocher-x12-SF.mp3',
			"default" => 'http://stream1.chantefrance.com/stream_chante_france.mp3'],
	"snooze" => [ "delay" => '+5 minutes'],
	"jeedom" => [ "scenario"=> 'http://#your jeedom IP#/core/api/jeeApi.php?apikey=#your Jeedom API key#&type=scenario&id="#Scenario ID#&action=start'],
		"active" => false]
];
````
<br>

|field|field|Description|
|--|--|--|
|**layout_title**|**title**| The name that will appear in the apps header|
|**tts**|**voiceRSSkey**| Replace #your VoiceRSS API key# by your API key|
||**vol**|Volume for TTS audio - Tune it to adapt the volume for your needs|
||**localTTS**|*true* to use local picoTTS or *false* to use VoiceRSS|
||**weatherUrl**| Replace #your city name# by the name of you city - see [www.prevision-meteo.ch](https://www.prevision-meteo.ch)|
||**jeedomUrl**| Replace #your jeedom IP#, #your Jeedom API key#, #your interaction query# (this last one is the interaction "Demande" field you've defined in jeedom (suggested one = tts)|
|**cron**|**path**|do not change unless you know what you're doing|
|**station**|**path**|do not change unless you know what you're doing|
||**local**|path of the local file that will be played when no internet is available when Radio is turned on - The one provided with this project is a nice country farmhouse bell|
||**default**|url of the default radio stream when you have no favorite in station.txt file, or when the file is corrupted after an upload|
||**snooze**|define you own snooze time|
|**jeedom**|**scenario**|Replace #your jeedom IP#, #your Jeedom API key#, #Scenario ID#. This last one is the Jeedom' scenario ID to call at each alarm event (recurring or not). It is activated when active is set to true (see below)|
||**active**|_true_\|_false_ to activate jeedom callback at each alarm event.|

- Where to find internet radio stream urls?

[http://www.listenlive.eu/](http://www.listenlive.eu/)
This is for EU stations. it is regularly updated when the urls are changed
- Where to find nice and fun local music file (if you do not like the country farmhouse bell) ?

[https://www.sound-fishing.net/bruitages_sonnerie-sonnette.html](https://www.sound-fishing.net/bruitages_sonnerie-sonnette.html)
Many file are free, other are available for relative low cost

<br><br><br>
__You're finished and can test__ [http://IP of your audio satellite](http://IP_of_your_audio_satellite) - __Enjoy !__
- reboot to check the defined alarms are effectively permanent 
>sudo shutdown -r now

