<?php
Flight::route('/',function(){
	Flight::util()->render('layout');
});

Flight::route('GET /getvol', ['logic' , 'getVolume']);
Flight::route('GET /setvol/@id:[1-9][0-9]?|100' , ['logic', 'setVolume']); // volume between 1 and 100

Flight::route('GET /radion', ['logic' , 'startRadio']);
Flight::route('GET /radioff', ['logic' , 'stopRadio']);
Flight::route('GET /snooze', ['logic' , 'snooze']);
Flight::route('GET /radiostate', ['logic' , 'statusRadio']);

Flight::route('GET /tts/@say', ['logic' , 'playTTS']);
Flight::route('GET /weather', ['logic' , 'ttsWeather']);
Flight::route('GET /jeedom', ['logic' , 'ttsJeedom']);

Flight::route('GET /getcron', ['logic' , 'getCron']);
Flight::route('GET /addcron', ['logic' , 'addCron']);
Flight::route('GET /delcron/@id:[0-9][0-9]*', ['logic' , 'delCron']);
Flight::route('GET /stacron/@id:[0-9][0-9]*/@state:on|off', ['logic' , 'stateCron']);
Flight::route('GET /nextcron', ['logic' , 'nextCron']);

Flight::route('GET /getat', ['logic' , 'getAt']);
Flight::route('GET /addat', ['logic' , 'addAt']);
Flight::route('GET /delat/@id:[1-9][0-9]*', ['logic' , 'delAt']);

Flight::route('GET /getstation', ['logic' , 'getStation']);
Flight::route('GET /selstation/@id:[0-9][0-9]*', ['logic' , 'selectStation']);
Flight::route('POST /upload', ['logic' , 'uploadStation']);
Flight::route('GET /download', ['logic' , 'downloadStation']);
