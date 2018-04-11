<?php
Flight::path("php/");
Flight::path("3rdparty/");

Flight::register('util','util');
Flight::register('tts','VoiceRSS');
Flight::register('nextcron','Crontab');
Flight::register('player','logic');

Flight::set('flight.log_errors', false);

//Flight::set("flight.base_url", $config['web']['base_url']);
Flight::set("layout_title", $config['layout_title']['title']);
Flight::set("ttsKey", $config['tts']['key']);
Flight::set("ttsVol", $config['tts']['vol']);
Flight::set("ttsWeather", $config['tts']['weatherUrl']);
Flight::set("ttsJeedom", $config['tts']['jeedomUrl']);

Flight::set("pathCron", $config['cron']['path']);
Flight::set("pathStation", $config['station']['path']);
Flight::set("defaultStation", $config['station']['default']);
Flight::set("snooze", $config['snooze']['delay']);

Flight::map('link',function($url){
	echo Flight::get('flight.base_url').$url;
});
Flight::map('notFound',function(){
	Flight::util()->render('404');
	die();
});
