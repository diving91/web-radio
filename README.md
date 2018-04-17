## Home automation audio satellite with web radio, text-to-speech and alarm clock features

Designed around a Raspberry-PI Zero W and a [HiFiBerry MiniAmp](https://www.hifiberry.com/shop/boards/miniamp/) audio amplifier board combined with a mini passive speaker.

I started this project because my alarm-clock's knobs were difficult to manipulate after years of service. In the same time I was searching for a way to diffuse Text-to-Speech messages from my [Jeedom](http://jeedom.fr) home automation system as well as being able to broadcast internet radio streams.

I decided to combine all needs in an all in one audio satellite with a RESTfull API in order to control it from my home automation system.

In order to have this audio satellite as autonomous as possible, in addition to the RESTfull API, I've made a web UI that I can run from my mobile phone or any browser.

Main features of this project are:
- Web radio with selectable channel from a playlist
- Volume control
- As many as needed daily recurring Alarm clock 
- As many as needed one shoot events to trigger Web radio On, Off or to play TTS messages
- Alarm Snooze function
- For higher reliability, alarm events are triggered locally from a crontab. Still the Home automation system can program alarm events issued from a calendar. 
- Still for reliability, when a web radio is not reachable, a local music file is played to ensure I'll wake up every mornings
- Play Text-to-Speech messages delivered by my home automation system
- Play local Text-to-Speech messages like weather forecast of the day
- Text-to-speech engine online [voicerss](http://www.voicerss.org/) or offline (libttspico-utils)
- RESTFull API with all functionalities included to control the audio satellite
- Local web application to control the audio satellite
- No knobs or display. My old alarm clock still projects time & temperature on the ceilling. For the knobs, I use a 4 buttons 433Mhz remote control that interacts with the audio satellite via Jeedom (or any other home automation system)

(french version)[]

## Documentation

- [API Documentation](https://github.com/diving91/web-radio/blob/master/doc/api.md)
- [Application UI user manual](https://github.com/diving91/web-radio/blob/master/doc/app%20user%20manual.png)

![Apps UI](https://github.com/diving91/web-radio/blob/master/doc/app_sml.jpg)

## How to build
... work in progress


