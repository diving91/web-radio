# Home automation Audio Satellite API Documentation


[Manage Global Volume](https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-global-volume)
[Manage Web Radio](https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-web-radio)
[Manage Text-to-speech (TTS)](https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-text-to-speech-tts)
[Manage alarm clock scheduler (recurring)](https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-alarm-clock-scheduler-recurring)
[Manage alarm clock scheduler (non recurring)](https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-alarm-clock-scheduler-non-recurring)
[Manage Web Radio Playlist](https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-web-radio-playlist)

# Embedded app
|Description|Local application|
|--|--|
|**URL**|**/**|
|Method|GET |
|URL params|None|
|Success|Render hosted apps|
|Error|none|

# Manage Global volume
|Description|Set current audio volume (1-100)|
|--|--|
|**URL**|**/setvol/@id**|
|Method|GET |
|URL params|none|
|Success|{"Status":"OK","Volume":"24"}|
|Error|{"Status":"KO","Volume":"Out of Range"}|
|Note|Volume is set permanent even after a shutdown|
|Example|/setvol/50|

## 

|Description|Get current audio volume (1-100)|
|--|--|
|**URL**|**/getvol**|
|Method|GET |
|URL params|none|
|Success|{"Status":"OK","Volume":"24"}|
|Error|none|

# Manage Web Radio

|Description|Turn Web Radio ON|
|--|--|
|**URL**|**/radion**|
|Method|GET |
|URL params|none|
|Success|{"Status":"OK","Radio":"Running","path":"http:\/\/stream_url.mp3"}|
||{"Status":"OK","Radio":"Was already Running"}|
|Error|none|
|Note|Stream Selected Radio in the Playlist|
||if no playlist, stream default Radio|
||if radio stream is not reachable, plays a local file|

##

|Description|Turn Web Radio OFF|
|--|--|
|**URL**|**/radioff**|
|Method|GET |
|URL params|none|
|Success|{"Status":"OK","Radio":"Stopped"}|
|Error|none|
|Note|It also turns off running TTS streams|

##
|Description|Snooze Web Radio|
|--|--|
|**URL**|**/snooze**|
|Method|GET |
|URL params|none|
|Success|{"Status":"OK","Snooze at":"HH:MM YYYY-MM-DD"}|
|Error|{"Status":"KO","Snooze at":"Radio was not running"}|
|Note|Snooze time is server side configured|

##
GET /radiostate
##
GET /radiotoggle

## Manage Text-to-speech (TTS)

GET /tts/@say
GET /weather
GET /jeedom

## Manage alarm clock scheduler (recurring)

GET /getcron
GET /addcron
GET /delcron/@id:[0-9][0-9]*
GET /stacron/@id:[0-9][0-9]*/@state:on|off
GET /nextcron


## Manage alarm clock scheduler (non recurring)
GET /getat
GET /addat
GET /delat/@id:[1-9][0-9]*

## Manage Web Radio Playlist 
GET /getstation
GET /selstation/@id:[0-9][0-9]*
POST /upload
GET /download

