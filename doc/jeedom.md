## Home automation examples with Jeedom

### Create with plugin "script" an equipment to control the audio satellite
 - Define a name for the equipment "audio1"
 - Select the parent object (here the room where the equipment is)
 - Click on the activate radio button
 - Do not click on the visible radio button
![script1](https://github.com/diving91/web-radio/blob/master/jeedom/script%201.png)
- In the command tab, define the actions & info you need to control the audio satellite: They have the form http://#IP#/command (commands are documented in the [API Documentation](https://github.com/diving91/web-radio/blob/master/doc/api.md))
- for an action, select type "http"/"action"/"default" and give a name to it
- for the TTS action, select "http"/"action"/"message" and give a name to it
- for all Text-to-Speech command, specify max retry of 1 and give a timeout long enough to allow the command to end.
- for an info, select "JSON"/"info"/"autre" and select the JSON param you need
 See the below examples
![script2](https://github.com/diving91/web-radio/blob/master/jeedom/script%202.png)
![script3](https://github.com/diving91/web-radio/blob/master/jeedom/script%203.png)

### Define the interaction answer called by /jeedom
- give it a name
- In the "Demande" field, specify the same name as what you've defined in the audio satellite config file for **tts/jeedomUrl** (see: 
 
![x](https://github.com/diving91/web-radio/blob/master/jeedom/interact%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/mode%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20cron%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20cron%202.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20onoff%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20onoff%202.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20telco%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20telco%202.png)


![x](https://github.com/diving91/web-radio/blob/master/jeedom/telco%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/virt%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/widget%201.png)


