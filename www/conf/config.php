<?php
$config = [
	//"web" => ["base_url" => ""],
	"layout_title" => ["title"	=> "Satellite Audio 1"],
	"tts" => [	"voiceRSSkey"	=> '#your VoiceRSS API key#',
			"vol"		=> 70,
			"localTTS"	=> true,
			"weatherUrl"	=> 'https://www.prevision-meteo.ch/services/json/#your city name#',
			"jeedomUrl"	=> 'http://192.168.1.108/core/api/jeeApi.php?apikey=#your Jeedom API key#&type=interact&query=#your interaction query#'],
	"cron" => [	"path"		=> '/srv/www/home.fr/public/conf/cron.txt'],
	"station" => [	"path"		=> '/srv/www/home.fr/public/station/station.txt',
			"local"		=> '/srv/www/home.fr/public/conf/clocher-x12-SF.mp3',
			"default"	=> 'http://stream1.chantefrance.com/stream_chante_france.mp3'],
	"snooze" => [	"delay"		=> '+5 minutes']	
 ];

