## Satellite audio domotique avec radio internet, fonctions de synthèse vocale et radio réveil  
  
Conçu autour d'un Raspberry-PI Zero W et d'un amplificateur audio [HiFiBerry MiniAmp] (https://www.hifiberry.com/shop/boards/miniamp/) combiné à un mini haut-parleur passif.  
  
J'ai commencé ce projet parce que les boutons de mon réveil étaient difficiles à manipuler après des années de service. Dans le même temps, je cherchais un moyen de diffuser les messages Text-to-Speech de mon système domotique [Jeedom] (http://jeedom.fr) ainsi des flux radio internet.  
  
J'ai décidé de combiner tous les besoins dans un satellite audio tout-en-un avec une API RESTfull afin de le contrôler depuis mon système domotique.  
  
Afin d'avoir ce satellite audio aussi autonome que possible, en plus de l'API RESTfull, j'ai créé une interface web que je peux utiliser depuis mon téléphone portable ou n'importe quel navigateur.  
  
Les principales caractéristiques de ce projet sont:  
- Radio intenet avec canal sélectionnable à partir d'une liste de lecture  
- Contrôle du volume  
- Alarme journalière périodique en nombre "illimité"
- Déclenchez des événements en nombre "illimité" pour activer, désactiver la radio ou diffuser des messages TTS  
- Fonction "snooze"
- Pour une meilleure fiabilité, les événements d'alarme sont déclenchés localement depuis un crontab. Le système domotique peut néanmoins programmer des événements d'alarme provenant d'un calendrier.  
- Toujours pour la fiabilité, quand une radio internet n'est pas accessible, un fichier musical local est joué pour m'assurer que je me réveille tous les matins  
- Lire les messages de synthèse vocale issus de mon système domotique  
- Lire des messages  de synthèse vocale locaux comme les prévisions météorologiques de la journée  
- Moteur de synthèse vocale en ligne [voicerss] (http://www.voicerss.org/) ou hors ligne (libttspico-utils)  
- API RESTFull avec toutes les fonctionnalités pour contrôler le satellite audio  
- Application Web locale pour contrôler le satellite audio  
- Pas de boutons ou d'affichage. Mon vieux réveil projette toujours le temps et la température au plafond. Pour les boutons, j'utilise une télécommande 4 boutons RF433Mhz qui interagit avec le satellite audio via Jeedom (ou tout autre système domotique)

