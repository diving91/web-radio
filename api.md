# Home automation Audio Satellite API Documentation
'/'
GET

# Titre de niveau 1
## Titre de niveau 2
GET /getvol

## Titre de niveau 2
GET /setvol/@id:[1-9][0-9]?|100

# Titre de niveau 1
GET /radion
GET /radioff
GET /snooze
GET /radiostate
GET /radiotoggle

Titre de niveau 1
=================
GET /tts/@say
GET /weather
GET /jeedom

Titre de niveau 1
=================
GET /getcron
GET /addcron
GET /delcron/@id:[0-9][0-9]*
GET /stacron/@id:[0-9][0-9]*/@state:on|off
GET /nextcron

Titre de niveau 1
=================
GET /getat
GET /addat
GET /delat/@id:[1-9][0-9]*

Titre de niveau 1
=================
GET /getstation
GET /selstation/@id:[0-9][0-9]*
POST /upload
GET /download
