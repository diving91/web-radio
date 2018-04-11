<!doctype html>
<html lang="fr">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Description  meta tags -->
 	<meta name="description" content="Audio Satellite">
	<meta name="author" content="Diving91 http://www.jeedom.fr/forum/" />
	<meta name="Owner" content="Diving91 http://www.jeedom.fr/forum/" />
	<meta name="Title" content="Audio Satellite" />
	<meta name="keywords" lang="fr" content= "Web Radio, Alarm Clock, TTS engine, Jeedom" />
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="./3rdparty/bootstrap/css/bootstrap.min.css"/>
	<!-- Material design CSS and fonts -->
	<!--link rel="stylesheet "href="./3rdparty/bootstrap-material-design/css/bootstrap-material-design.min.css"/>
	<link rel="stylesheet "href="./3rdparty/bootstrap-material-design/css/ripples.min.css"/-->
	<link rel="stylesheet " href="./3rdparty/bootstrap-material-datetimepicker-2.7.1/css/bootstrap-material-datetimepicker.css" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!-- this site CSS -->
	<link rel="stylesheet " href="./css/layout.css?v=1" />	

	<title>Audio Satellite</title>
 </head>
 <body>
	<!-- Image and text Page Header -->
	<nav class="navbar sticky-top navbar-dark bg-dark text-YellowGreen font-weight-bold">
		<div><i class="material-icons md-36">speaker</i>
		<i class="material-icons md-18">surround_sound</i>
		<i class="material-icons md-36">speaker</i></div>
		<div id="div_horloge"></div>
		<?php echo Flight::get('layout_title'); ?>
	</nav>
 
	<!-- Radio ON/OFF & Volume-->
	<div class="control">
		<button id="btnradio" type="button" class="btn my-primary"><i class="material-icons md-24">radio</i><i id="radiostate" class="material-icons md-24">volume_up</i></button>
		<input id="btnvol" type="range" min="1" max="100" value="50">
		<span id="valvol" class="badge my-primary">50</span>
		<button id="btnsnooze" type="button" class="btn my-primary"><i class="material-icons md-24">snooze</i></button>
	</div>

	<!--  Alarm Clock Controls -->
	<div class="control">
		<!-- Cron list -->
		<button id="showcron" type="button" class="btn my-primary"><i class="material-icons md-24">alarm</i></button>
		<!-- Add Alarm -->
		<button id="addcron" type="button" class="btn my-primary"><i class="material-icons md-24">alarm_add</i></button>
		<!-- Next Alarm -->
		<button id="nextcron" type="button" class="btn my-primary"><i class="material-icons md-24">access_time</i></button>
		<!-- at list -->
		<button id="showat" type="button" class="btn my-primary"><i class="material-icons md-24">notifications_active</i></button>
		<!-- Add at -->
		<button id="addat" type="button" class="btn my-primary"><i class="material-icons md-24">add_alert</i></button>
	</div>
	<div id="listcron" style = "display:none;"></div>
	<div id="listat" style = "display:none;"></div>

	<!--  Radio Playlist Controls -->
	<div class="control">
		<!-- Station list -->
		<button id="showstation" type="button" class="btn my-primary"><i class="material-icons md-24">queue_music</i></button>
		<!-- Station upload -->
		<button id="upstation" type="button" class="btn my-primary"><i class="material-icons md-24">file_upload</i></button>
		<!-- Station download -->
		<button id="downstation" type="button" class="btn my-primary"><i class="material-icons md-24">file_download</i></button>
	</div>
	<form id="upform" enctype="multipart/form-data" style = "display:none;">
	    <input id="fileselect" name="file" type="file" />
	    <input id="fileupload" type="button" value="Charger" disabled/>
	</form>
	<div id="liststation" style = "display:none;"></div>

	<!--  TTS Controls -->
	<div class="control">
		<!-- Play TTS -->
		<button id="weathertts" type="button" class="btn my-primary"><i class="material-icons md-24">filter_drama</i></button>
		<button id="jeedomtts" type="button" class="btn my-primary"><i class="material-icons md-24 icon">record_voice_over</i></button>
	</div>

	<!--  Copyright -->
	<a href="https://github.com/diving91 "target="_blank">&copy;Diving91</a>

	<!-- Modal to Select Day of Week -->
	 <div id = "weekDay" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header mhp"> <h4 class="modal-title" id="modaltime">time</h4> <button type="button" class="close" data-dismiss="modal" aria-label="X"> <span aria-hidden="true">&times;</span> </button> </div>
				<div class="modal-body">
						<button id="cronLu" type="button" class="btn my-secondary">L</button>
						<button id="cronMa" type="button" class="btn my-secondary">M</button>
						<button id="cronMe" type="button" class="btn my-secondary">M</button>
						<button id="cronJe" type="button" class="btn my-secondary">J</button>
						<button id="cronVe" type="button" class="btn my-secondary">V</button>
						<button id="cronSa" type="button" class="btn my-secondary">S</button>
						<button id="cronDi" type="button" class="btn my-secondary">D</button>
						<div class="form-group">
							<label for="exampleFormControlTextarea1"></label>
							<input id="cronTxt" class="form-control form-control-sm" type="text" placeholder="Commentaire">
						</div>
				</div>
				<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button></div>
			</div>
		</div>
	</div>

	<!-- Modal to Select AT type -->
	<div id = "attype" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header mhp"> <h4 class="modal-title" id="atdate">date</h4> <button type="button" class="close" data-dismiss="modal" aria-label="X"> <span aria-hidden="true">&times;</span> </button> </div>
				<div class="modal-body">
					<button id="ataddon" type="button" class="btn my-secondary" data-dismiss="modal"><i class="material-icons md-24">volume_up</i></button>
					<button id="ataddoff" type="button" class="btn my-secondary" data-dismiss="modal"><i class="material-icons md-24">volume_off</i></button>
					<button id="ataddtts" type="button" class="btn my-secondary" data-dismiss="modal"><i class="material-icons md-24">record_voice_over</i></button>
				</div>
			</div>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first,then popper & Bootstrap JS -->
	<script src="./3rdparty/bootstrap/js/jquery-3.3.1.min.js"></script> 
	<script src="./3rdparty/bootstrap/js/popper.min.js"></script>
	<script src="./3rdparty/bootstrap/js/bootstrap.min.js"></script>

	<!-- DateTime picker JS -->
	<!--script src="./3rdparty/bootstrap-material-design/js/ripples.min.js"></script>
	<script src="./3rdparty/bootstrap-material-design/js/bootstrap-material-design.min.js"></script-->
	<script type="text/javascript" src="./3rdparty/bootstrap-material-datetimepicker-2.7.1/js/moment-with-locales.min.js"></script>
	<script type="text/javascript" src="./3rdparty/bootstrap-material-datetimepicker-2.7.1/js/bootstrap-material-datetimepicker.js"></script>

	<!-- slider touch control JS -->
	<script type="text/javascript" src="./3rdparty/range-touch/range-touch.min.js"></script>
	
	<!-- this site JS -->
	<script src="./js/layout.js"></script>
</body>
</html>