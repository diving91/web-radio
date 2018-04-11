// Todo
// check internet and default to local mp3 when KO
// voiceRSS vs picosvox (?)

// Globals
var radioState;  // boolean to check Radio is running or not
var cronWeek = [true,true,true,true,true,true,true];
var cronTime;
var atDate;
var cronDisplayed = false;
var atDisplayed = false;
var stationDisplayed = false;
var atIsType = 'off';

$(document).ready( function() {
	$.ajaxSetup({ cache: false }); // fix for IE browser
	
	// init UI
	init();
	horloge('div_horloge');

	// Volume controller
	$('#btnvol').change(function() {
		volume = $('#btnvol').val();
		$.getJSON('./setvol/'+volume, function(data) {
			$('#valvol').text(data.Volume);
		});
	});

	// Radio ON/OFF controller
	$('#btnradio').click(function() {
		if (radioState) api = './radioff';
		else api = './radion';
		$.getJSON(api, function(data) {
			if (data.Status == 'OK' && radioState == false) {
				radioState = true;
				$('#radiostate').text('volume_up');
			}
			else if (data.Status == 'OK' && radioState == true) {
				radioState = false;
				$('#radiostate').text('volume_off');
			}
		});
	});

	// Snooze
	$('#btnsnooze').click(function() {
		$.getJSON('./snooze', function(data) {
			console.log(data);
		});		
	});

	// Show/Hide cron list
	$('#showcron').click(function() {
		if (cronDisplayed == false) {
			showCronEntry();	
			cronDisplayed=true;
			$('#listcron').show();	
		}
		else {
			cronDisplayed = false;
			$('#listcron').hide();
		}
	});

	// Toggle cron item on/off
	$('body').on('click', 'button.cronentry', function() {
		index = $( ".cronentry" ).index( this );
		//console.log('toggle '+index);
		state = $(this).find('.material-icons').text()
		if (state == 'alarm_on') {
			$.getJSON('./stacron/'+index+'/off', function(data) {
				//console.log(data)		
				showCronEntry();
			});
		}
		else if (state == 'alarm_off') {
			$.getJSON('./stacron/'+index+'/on', function(data) {
				//console.log(data)		
				showCronEntry();
			});
		}
	});

	// Delete cron entry
	$('body').on('click', 'button.delcronentry', function() {
		index = $( ".delcronentry" ).index( this );
		//console.log('delete '+index);
		$.getJSON('./delcron/'+index, function(data) {
			//console.log(data.Status)		
			showCronEntry();
		});
	});

	// Add Cron entry Time picker
	// https://github.com/T00rk/bootstrap-material-datetimepicker
	$('#addcron').bootstrapMaterialDatePicker({
		date: false,
		shortTime: false,
		format: 'HH:mm',
		cancelText : 'Annuler',
		nowButton : true,
		nowText : 'Maintenant',
		switchOnClick : false,
		okText : 'ok'
	}).on('change', function (e, time) { //After time set, show modal for day of Week selection
		cronTime = moment(time).format('HH:mm')
		$('#modaltime').text(cronTime);
		$('#weekDay').modal({
			backdrop: 'static',
			show: true
		});
	});
	$('#cronLu').click(function() {
		if (cronWeek[1] == true) { $('#cronLu').css('background-color','red'); cronWeek[1] = false;}
		else { $('#cronLu').css('background-color',''); cronWeek[1] = true;}
	});
	$('#cronMa').click(function() {
		if (cronWeek[2] == true) { $('#cronMa').css('background-color','red'); cronWeek[2] = false;}
		else { $('#cronMa').css('background-color',''); cronWeek[2] = true;}
	});
	$('#cronMe').click(function() {
		if (cronWeek[3] == true) { $('#cronMe').css('background-color','red'); cronWeek[3] = false;}
		else { $('#cronMe').css('background-color',''); cronWeek[3] = true;}
	});
	$('#cronJe').click(function() {
		if (cronWeek[4] == true) { $('#cronJe').css('background-color','red'); cronWeek[4] = false;}
		else { $('#cronJe').css('background-color',''); cronWeek[4] = true;}
	});
	$('#cronVe').click(function() {
		if (cronWeek[5] == true) { $('#cronVe').css('background-color','red'); cronWeek[5] = false;}
		else { $('#cronVe').css('background-color',''); cronWeek[5] = true;}
	});
	$('#cronSa').click(function() {
		if (cronWeek[6] == true) { $('#cronSa').css('background-color','red'); cronWeek[6] = false;}
		else { $('#cronSa').css('background-color',''); cronWeek[6] = true;}
	});
	$('#cronDi').click(function() {
		if (cronWeek[0] == true) { $('#cronDi').css('background-color','red'); cronWeek[0] = false;}
		else { $('#cronDi').css('background-color',''); cronWeek[0] = true;}
	});
	$('#weekDay').on('hidden.bs.modal', function() { // Now we have all cron info: Passing to backend
		//console.log(cronTime, cronWeek, $('#cronTxt').val());
		cron = JSON.stringify({ t: cronTime, d: cronWeek, c: $('#cronTxt').val() });
		//console.log(cron);
		$.getJSON('./addcron?cron='+cron, function(data) {
			//console.log(data.Cron)
			showCronEntry();
		});
	});

	// Next cron alarm time
	$('#nextcron').click(function() {
		$.getJSON('./nextcron', function(data) {
			if (data.Status == 'OK') alert('Prochain Reveil \n'+data.Time);
			else alert('Aucun Reveil en cours');
		});		
	});

	// Show At list
	$('#showat').click(function() {
		if (atDisplayed == false) {
			showAtEntry();	
			atDisplayed=true;
			$('#listat').show();	
		}
		else {
			atDisplayed = false;
			$('#listat').hide();
		}
	});

	// Add At entry
	$('#addat').bootstrapMaterialDatePicker({
		date: true,
		format : 'DD/MM/YYYY HH:mm',
		lang : 'fr', 
		weekStart : 1,
		minDate : new Date(),
		shortTime: false,
		format: 'HH:mm',
		cancelText : 'Annuler',
		nowButton : true,
		nowText : 'Maintenant',
		switchOnClick : false,
		okText : 'ok'
	}).on('change', function (e, time) { //After time set, show modal for day of Week selection
		atDate = moment(time).format('DD/MM/YYYY HH:mm')
		$('#atdate').text(atDate);
		$('#attype').modal({
			backdrop: 'static',
			show: true
		});
	});
	$('#ataddon').click(function() {
		atIsType = 'on';
	});
	$('#ataddoff').click(function() {
		atIsType = 'off';
	});
	$('#ataddtts').click(function() {
		atIsType = 'tts';
	});	
	$('#attype').on('hidden.bs.modal', function() { // Now we have all AT info: Passing to backend
		at = JSON.stringify({ d: moment(atDate,'DD/MM/YYYY HH:mm').unix(), t: atIsType });
		$.getJSON('./addat?at='+at, function(data) {
			console.log(data.At)
			showAtEntry();
		});
	});
	
	// Delete At entry
	$('body').on('click', 'button.delatentry', function() {
		index = $(this).val();
		console.log('delete '+index);
		$.getJSON('./delat/'+index, function(data) {
			console.log(data);	
			showAtEntry();
		});
	});

	// Show/Hide station list
	$('#showstation').click(function() {
		if (stationDisplayed == false) {
			showStationEntry();	
			stationDisplayed=true;
			$('#liststation').show();	
		}
		else {
			stationDisplayed = false;
			$('#liststation').hide();
		}	
	});

	// Select active radio
	$('body').on('click', 'button.stationentry', function() {
		index = $( ".stationentry" ).index( this );
		//console.log('station '+index);
		state = $(this).find('.material-icons').text()
		if (state == 'favorite_border') {
			$.getJSON('./selstation/'+index, function(data) {
				//console.log(data)		
				showStationEntry();
			});
		}
	});

	// Upload Station file	
	$('#upstation').on('click', function() {
		$('#upform').toggle();
	});
	$('#fileselect').on('change', function() {
		var file = this.files[0];
		if (file.size > 4096 || file.type != "text/plain") {
			alert('Taille Max 4K, Fichier texte');
			$("#fileupload").prop('disabled', true);
		}
		else $("#fileupload").prop('disabled', false);
	});
	$('#fileupload').on('click', function() {
		$.ajax({
			url: './upload',
			type: 'POST',
			// Form data
			data: new FormData($('form')[0]),
			// Tell jQuery not to process data or worry about content-type
			// You *must* include these options!
			cache: false,
			contentType: false,
			processData: false,
		});
	});

	// Download Station file - Requires IE13/Edge - Doe²s not work with Safari
	$('#downstation').click(function() {
		var file_path = './station/station.txt';
		var a = document.createElement('A');
		a.href = file_path;
		a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
		document.body.appendChild(a);
		a.click();
		document.body.removeChild(a);
		/*$.getJSON('./download', function(data) {
		});*/
	});

	// Local weather
	$('#weathertts').click(function() {
		$(this).prop("disabled",true);
		$.getJSON('./weather', function(data) {
			$('#weathertts').prop("disabled",false);
		});
	});

	// Local weather
	$('#jeedomtts').click(function() {
		$(this).prop("disabled",true);
		$.getJSON('./jeedom', function(data) {
			$('#jeedomtts').prop("disabled",false);
		});
	});	
});

function init() {
	// Display Radio ON/OFF
	$.getJSON('./radiostate', function(data) {
		if (data.Radio == 'Running') { radioState = true; $('#radiostate').text('volume_up');}
		if (data.Radio == 'Stopped') { radioState = false; $('#radiostate').text('volume_off');}
	});
	// Display Radio Volume
	$.getJSON('./getvol', function(data) {
		$('#valvol').text(data.Volume);
		$('#btnvol').val(data.Volume);
	});
}

function showCronEntry() {
	$.getJSON('./getcron', function(data) {
		var txt = '';
		var tmpcron = [];
		if (data.Status == "OK") {
			for (i = 0; i < data.cron.length; i++) { 
				x = data.cron[i].active ? 'on':'off';
				txt += '<button type="button" class="btn my-primary cronentry">';
				txt += '<i class="material-icons md-18">alarm_'+x+'</i>';
				txt += '</button>';
				txt += '<button type="button" class="btn my-primary delcronentry">';
				txt += '<i class="material-icons md-18">delete_forever</i>';
				txt += '</button>';
				txt += ' '+String("00" + data.cron[i].hh).slice(-2);
				txt += ':'+String("00" + data.cron[i].mm).slice(-2);
				x = data.cron[i].dd;
				for (d = 0; d < 7; d++) { 
					tmpcron[d] = (x.search(d) == -1) ? false:true;
				}
				//console.log(tmpcron);
				txt += ' ';
				txt += '<span class="badge '+(tmpcron[1]?'badge-success':'badge-danger')+'">L</span>';
				txt += '<span class="badge '+(tmpcron[2]?'badge-success':'badge-danger')+'">M</span>';
				txt += '<span class="badge '+(tmpcron[3]?'badge-success':'badge-danger')+'">M</span>';
				txt += '<span class="badge '+(tmpcron[4]?'badge-success':'badge-danger')+'">J</span>';
				txt += '<span class="badge '+(tmpcron[5]?'badge-success':'badge-danger')+'">V</span>';
				txt += '<span class="badge '+(tmpcron[6]?'badge-success':'badge-danger')+'">S</span>';
				txt += '<span class="badge '+(tmpcron[0]?'badge-success':'badge-danger')+'">D</span>';
				txt += ' ('+data.cron[i].name+')';
				txt +='<div></div>';
			}
			$('#listcron').html(txt);
		}
		else $('#listcron').html('<span>Aucune Alarme</span>');
	});
}

function showAtEntry() {
	$.getJSON('./getat', function(data) {
		var txt = '';
		if (data.Status == "OK") {
			for (i = 0; i < data.At.length; i++) {
				switch(data.At[i].type) {
					case 'A': icon = 'volume_up'; break;
					case 'B': icon = 'volume_off'; break;
					case 'C': icon = 'record_voice_over'; break;
				} 
				txt += '<button type="button" class="btn my-primary delatentry" value="'+data.At[i].id+'">';
				txt += '<i class="material-icons md-18">delete_forever</i>';
				txt += '</button>';
				txt += '<i class="material-icons md-18">'+icon+'</i>';
				txt += ' '+data.At[i].date;
				txt +='<div></div>';
			}
			$('#listat').html(txt);
		}
		else $('#listat').html('<span>Aucune Alarme</span>');
	});
}

function showStationEntry() {
	$.getJSON('./getstation', function(data) {
		var txt = '';
		if (data.Status == "OK") {
			for (i = 0; i < data.station.length; i++) {
				x = (data.station[i].selected == 1)  ? '':'_border';
				txt += '<button type="button" class="btn my-primary stationentry">';
				txt += '<i class="material-icons md-18">favorite'+x+'</i>';
				txt += '</button>';
				txt += ' '+data.station[i].name;
				txt +='<div></div>';
			}
			$('#liststation').html(txt);
		}
		else $('#liststation').html('<span>Aucune Station</span>');
	});
}

function horloge(el) {
	if(typeof el=="string") { el = document.getElementById(el); }
	function actualiser() {
		var date = new Date();
		var str = (date.getHours()<10?'0':'')+date.getHours();
		str += ':'+(date.getMinutes()<10?'0':'')+date.getMinutes();
		str += ':'+(date.getSeconds()<10?'0':'')+date.getSeconds();
		el.innerHTML = str;
	}
	actualiser();
	setInterval(actualiser,1000);
}