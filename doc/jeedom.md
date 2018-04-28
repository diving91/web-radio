## Home automation examples with Jeedom

### Create with the "script" plugin an equipment to control the audio satellite
 - Define a name for the equipment "audio1"
 - Select the parent object (here the room where the equipment is)
 - Click on the activate radio button
 - Do not click on the visible radio button
![script1](https://github.com/diving91/web-radio/blob/master/jeedom/script%201.png)
- In the command tab, define the actions & info you need to control the audio satellite: They have the form http://#IP#/command (commands are documented in the [API Documentation](https://github.com/diving91/web-radio/blob/master/doc/api.md))
- For an action, select type "http"/"action"/"default" and give a name to it
- For the TTS action, select "http"/"action"/"message" and give a name to it
- For all Text-to-Speech command, specify max retry of 1 and give a timeout long enough to allow the command to end.
- For an info, select "JSON"/"info"/"autre" and select the JSON param you need
 
 See the below examples
![script2](https://github.com/diving91/web-radio/blob/master/jeedom/script%202.png)
![script3](https://github.com/diving91/web-radio/blob/master/jeedom/script%203.png)

### Define a widget with the "virtual" & "widget" plugins
- Via the jeedom market add this widget: **dashboard.info.string.alarm-clock** - you can download it [here](https://www.jeedom.com/market/core/php/downloadFile.php?id=1872&version=stable)
- With the "virtual" plugin create a virtual. In the equipment tab, leave the "Auto-actualisation (cron)" field empty. Click "Activer" & "Visible"
- In the "Command tab", do as in the below image
![virtual](https://github.com/diving91/web-radio/blob/master/jeedom/virt%201.png)
- For the "Reveil" Command, click the gear wheel at the right
- In the "Affichage" tab, select "alarm-clock(widget) for the Dashboard widget
- For the "On" & "Off" Commands, use the **dashboard.action.other.ToggleSwitchIMG** widget (see Jeedom forum to configure it)
- Click on "Save"

You now have this widget on our dashboard

![widget](https://github.com/diving91/web-radio/blob/master/jeedom/widget%201.png)


### Define the interaction answer called by /jeedom
- Give it a name
- In the "Demande" field, specify the same name as what you've defined in the audio satellite config file for **tts/jeedomUrl** (see: [Application & API setup](https://github.com/diving91/web-radio/blob/master/doc/application.md))
![Interaction](https://github.com/diving91/web-radio/blob/master/jeedom/interact%201.png)



![x](https://github.com/diving91/web-radio/blob/master/jeedom/mode%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20cron%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20cron%202.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20onoff%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20onoff%202.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20telco%201.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20telco%202.png)
![x](https://github.com/diving91/web-radio/blob/master/jeedom/telco%201.png)



