## Exemples domotique avec Jeedom

### Créer un équipement pour contrôler le satellite audio avec le plugin "script"
 - Définir un nom  pour l'équipement "audio1"
 - Sélectionner un objet parent (ici la pièce où se trouve l'équipement)
 - Cliquer sur "activer"
 - Ne pas cliquer sur "visible"
![script1](https://github.com/diving91/web-radio/blob/master/jeedom/script%201.png)
- Dans l'onglet commande, définir les actions & infos dont vous avez besoin pour contrôler le satellite audio: Elles ont la forme http://#IP#/commande (les commandes sont documentées dans la [Documentation API](https://github.com/diving91/web-radio/blob/master/doc/api.md))
- Pour une action, sélectionner le type "http"/"action"/"défaut" et donner lui un nom
- Pour l'action TTS , sélectionner le type "http"/"action"/"message" et donner lui un nom
- Pour toutes les commandes Text-to-Speech, spécifier un nombre maxi d'essai de 1 et définir un timeout assez long pour permettre à la commande de se terminer.
- Pour une info, sélectionner "JSON"/"info"/"autre" et sélectionner le paramètre JSON dont vous avez besoin.
 
 Voir les exemples ci-dessous
![script2](https://github.com/diving91/web-radio/blob/master/jeedom/script%202.png)
![script3](https://github.com/diving91/web-radio/blob/master/jeedom/script%203.png)

### Définir un widget avec les plugins "virtuel" & "widget" 
Via le market de jeedom ajoutez ce widget: **dashboard.info.string.alarm-clock** - Vous pouvez le télécharger [ici](https://www.jeedom.com/market/core/php/downloadFile.php?id=1872&version=stable)
- Avec le plugin "virtuel" créer un virtuel. Dans l'onglet Équipement, laissez le champ "Auto-actualisation (cron)" vide. Cliquez sur "Activer" & "Visible"  
- Dans l'onglet "Commande", faites comme dans l'image ci-dessous![virtual](https://github.com/diving91/web-radio/blob/master/jeedom/virt%201.png)
- Pour la commande "Reveil", cliquez sur la roue dentée à droite  
- Dans l'onglet "Affichage", sélectionnez "alarm-clock (widget)" pour le widget Dashboard  
- Pour les commandes "On" et "Off", utilisez le widget **dashboard.action.other.ToggleSwitchIMG** (voir le forum Jeedom pour le configurer)  
- Cliquez sur "Enregistrer"

Vous avez maintenant ce widget sur votre tableau de bord

![widget](https://github.com/diving91/web-radio/blob/master/jeedom/widget%201.png)


### Définir l'interaction appelée par l'appel /jeedom de l'API
- Donner lui un nom
- Dans le champ "Demande" , spécifiez le même nom que celui que vous avez défini dans le fichier de configuration du satellite audio pour **tts/jeedomUrl** (see: [Application & API setup](https://github.com/diving91/web-radio/blob/master/doc/application.md))
![Interaction](https://github.com/diving91/web-radio/blob/master/jeedom/interact%201.png)

### Utilisez le plugin "Mode" pour désactiver automatiquement tous les événements d'alarme lorsque vous partez pour les vacances
- Ajouter cette condition d'entrée dans le mode Vacances
![holidays](https://github.com/diving91/web-radio/blob/master/jeedom/mode%201.png)

### Ajouter des boutons physiques au satellite audio
- Dans mon cas, j'ai utilisé une télécommande RF433Mhz avec 4 boutons qui est contrôlée avec le plugin "RFXCOM" et le boîtier RFXCOM  
- J'ai programmé les 4 boutons comme dans l'image ci-dessous (voir sur le forum pour voir comment faire)
![remote](https://github.com/diving91/web-radio/blob/master/jeedom/telco%201.png)

- Créer un scénario pour la télécommande en utilisant 4 déclencheurs (un par bouton)
![scn remote 1](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20telco%201.png)
- Pour chaque déclencheur, définissez l'action correspondante lorsque vous appuyez sur le bouton (condition "équipement == 1")
![scn remote 2](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20telco%202.png)

### Ajouter un scénario pour contrôler le satellite audio ON & OFF (à partir de son widget)
- Sélectionnez la commande "Mode" du virtuel que nous avons défini ci-dessus comme déclencheur de scénario
![scn mode](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20onoff%201.png)
- Ajoutez les conditions de test et les actions ci-dessous
![scn mode 1](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20onoff%202.png)

### Ajouter un scénario pour définir une autre tâche d'automatisation à chaque événement d'alarme
- Définir un déclencheur programmé pour ce scénario à 00:01  
- À 00:01 tous les jours, il mettra à jour l'heure d'alarme du jour sur le widget  
- Ensuite, le satellite audio appellera lui-même ce scénario à chaque événement d'alarme pour afficher l'heure du réveil suivant de la journée  
- Ce scénario permet de déclencher d'autres actions (allumer la lumière, etc ...) selon vos besoins
![scn alarm](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20cron%201.png)
![scn alarm 1](https://github.com/diving91/web-radio/blob/master/jeedom/scn%20cron%202.png)
- Le premier bloc "Action" est utilisé pour actualiser l'affichage du widget pour afficher l'événement d'alarme suivant de la journée. Grâce à cela, vous pouvez avoir plusieurs alarmes sur une même journée.
- Le bloc suivant est déclenché lorsque le satellite audio rappelle le scénario tel que défini par le paramètre du fichier de configuration **jeedom / scenario** (voir: [Application & API setup](https://github.com/diving91/web-radio/blob/master/doc/application.md))
- Dans l'exemple ci-dessus, j'ai ajouté un message de synthèse vocale 4 minutes après l'événement d'alarme ... pour me rappeler que je dois sortir du lit :-)  
- Vous pouvez définir n'importe quelle tâche qui répond à vos besoins, comme l'éclairage d'une lampe, l'ouverture des volets ou tout ce qui est contrôlé par Jeedom. **C'est vraiment cool!**
### Aller plus loin ...
Vous pouvez faire beaucoup plus en utilisant l'API du satellite audio et des scripts plus complexes ou des blocs "code" dans les scénarios. Par exemple, vous pouvez lier un calendrier avec le satellite audio pour définir automatiquement les événements d'alarme. Ou vous pouvez gérer à distance votre web radio préférée, les montrer sur un virtuel, etc.

Pour cela, vous aurez besoin de compétences de programmation un peu plus avancées - Le [forum](https://www.jeedom.fr/forum/) est là pour vous aider.
N'hésitez pas à regarder la [Documentation API](https://github.com/diving91/web-radio/blob/master/doc/api.md) pour voir toutes les possibilités


