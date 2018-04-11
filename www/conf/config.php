<?php
$config = [
	//"web" => ["base_url" => ""],
	"layout_title" => ["title" => "Satellite Audio 1"],
	"tts" => [	"key" => '#your VoiceRSS API key#',
			"vol" => 60,
			"weatherUrl" => 'https://www.prevision-meteo.ch/services/json/#your city name#',
			"jeedomUrl" => 'http://192.168.1.108/core/api/jeeApi.php?apikey=#your Jeedom API key#&type=interact&query=#your interaction query#'],
	"cron" => [	"path" => '/srv/www/home.fr/public/conf/cron.txt'],
	"station" => [	"path" => '/srv/www/home.fr/public/station/station.txt',
			"default" => 'http://stream.chantefrance.com/stream_chante_france.mp3'],
	"snooze" => [	"delay" => '+5 minutes']
 ];
