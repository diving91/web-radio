## Exemples domotique avec Jeedom

### Créer un équipement pour contrôler le satellite audio avec le plugin "script"
 - Définir un nom  pour l'équipement "audio1"
 - Sélectionner un objet parent (ici la pièce où se trouve l'équipement)
 - Cliquer sur "activer"
 - Ne pas cliquer sur "visible"
![script1](https://github.com/diving91/web-radio/blob/master/jeedom/script%201.png)
- Dans l'onglet commande, définir les actions & infos dont vous avez besoin pour contrôler le satellite audio: Elles ont la forme http://#IP#/commande (les commandes sont documentées dans [API Documentation](https://github.com/diving91/web-radio/blob/master/doc/api.md))
- Pour une action, sélectionner le type "http"/"action"/"défaut" et donner lui un nom
- Pour l'action TTS , sélectionner le type "http"/"action"/"message" et donner lui un nom
- Pour toutes les commandes Text-to-Speech, spécifier un nombre maxi d'essai de 1 et définir un timeout assez long pour permettre à la commande de se terminer.
- Pour une info, sélectionner "JSON"/"info"/"autre" et sélectionner le paramètre JSON dont vous avez besoin.
 
 Voir les exemples ci-dessous
![script2](https://github.com/diving91/web-radio/blob/master/jeedom/script%202.png)
![script3](https://github.com/diving91/web-radio/blob/master/jeedom/script%203.png)

### Définir un widget avec les plugins "virtuel" & "widget" 
Via le market de jeedom ajoutez ce widget: **dashboard.info.string.alarm-clock** - Vous pouvez le télécharger ici [here](https://www.jeedom.com/market/core/php/downloadFile.php?id=1872&version=stable)
- Avec le plugin "virtuel" créer un virtuel. Dans l'onglet Équipement, laissez le champ "Auto-actualisation (cron)" vide. Cliquez sur "Activer" & "Visible"  
- Dans l'onglet "Commande", faites comme dans l'image ci-dessous![virtual](https://github.com/diving91/web-radio/blob/master/jeedom/virt%201.png)
- Pour la commande "Reveil", cliquez sur la roue dentée à droite  
- Dans l'onglet "Affichage", sélectionnez "alarm-clock (widget)" pour le widget Dashboard  
- Pour les commandes "On" et "Off", utilisez le widget **dashboard.action.other.ToggleSwitchIMG** (voir le forum Jeedom pour le configurer)  
- Cliquez sur "Enregistrer"

Vous avez maintenant ce widget sur votre tableau de bord

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


