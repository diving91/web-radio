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

You now have this widget on your dashboard

![widget](https://github.com/diving91/web-radio/blob/master/jeedom/widget%201.png)


### Define the interaction answer called by the /jeedom API call
- Give it a name
- In the "Demande" field, specify the same name as what you've defined in the audio satellite config file for **tts/jeedomUrl** (see: [Application & API setup](https://github.com/diving91/web-radio/blob/master/doc/application.md))
![Interaction](https://github.com/diving91/web-radio/blob/master/jeedom/interact%201.png)

### Use the "Mode" plugin to automatically switch off all alarm events when you leave for holidays
- Add this entry condition in the Holidays' Mode
![holidays](https://github.com/diving91/web-radio/blob/master/jeedom/mode%201.png)

### Add physical buttons to the audio satellite
- In my case I've used a RF433Mhz remote control with 4 buttons which is controlled with the "RFXCOM" plugin and the RFXCOM box
- I've programmed the 4 buttons as in the image below (see on the forum hor an how to)
![remote](https://github.com/diving91/web-radio/blob/master/jeedom/telco%201.png)

- Create a scenario for the remote control using 4 triggers (one per button)
![scn remote 1](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20telco%201.png)
- For each trigger, define the relevant action when the button is pressed (condition "equipment==1")
![scn remote 2](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20telco%202.png)

### Add a scenario to control the audio satellite ON & OFF (from its widget)
- Select the command "Mode" from the virtual we've defined above as scenario trigger
![scn mode](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20onoff%201.png)
- Add the below test conditions and actions
![scn mode 1](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20onoff%202.png)

### Add a scenario to define other automation task at each alarm event
- Define a programmed trigger for this scenario at 00:01
- At 00:01 every days it will update the alarm time of day on the widget
- Then the audio satellite itself will call this scenario at each alarm event to display the time of the next alarm clock of the day
- This scenario allows to trigger other actions (turn on light, etc ...) as you need
![scn alarm](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20cron%201.png)
![scn alarm 1](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20cron%202.png)
- The first "Action" block is used to refresh the widget display to show the next alarm event of the day. Thanks to this, you can have multiple alarms in one day.
- The next block is fired when the audio satellite calls back the scenario  as defined is the config file **jeedom/scenario** parameter (see: [Application & API setup](https://github.com/diving91/web-radio/blob/master/doc/application.md))
- In the above example, I've added a Text-to-speech message 4 minutes after the alarm event ... to remind me I need to go out of bed :-)
- You can define any task that suits your need such as lighting on a lamp, opening the fence, or whatever is controlled by jeedom. **That's really cool stuff !**
### Going further
You can do much more by using the audio satellite API and more complex scripts or "code" blocks in scenarios. Eg you can link a calendar with the audio satellite to automatically define the alarm events. Or you can remotely manage your favorite web radio, show them on a virtual, etc etc.

For this you need more advanced programming skills - The [forum](https://www.jeedom.fr/forum/) is there to help you.
Don't hesitate to look at the [API Documentation](https://github.com/diving91/web-radio/blob/master/doc/api.md) to see all possibilities




