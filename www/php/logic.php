<?php
/*
* Copyright (c) 2018 Diving-91 (User:diving91 https://www.jeedom.fr/forum/)
* URL: https://github.com/diving91/Internet-Radio
* 
* MIT License
* Copyright (c) 2018
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*
*/

/*
	Audio Satellite for Home automation system
	Internet Radio with Playlist
	Alarm clock with cron style recurring alarms and one shot alarm date-time
	Snooze feature
	Text to Speech information
	All control with RESTfull API and embedded front end
	Run & Tested on RaspBerry PI Zero W with hifiBerry mini Audio Amplifier
*/

class Logic {
	// Return cron entries in www-data crontab
	// inspired by http://www.kavoir.com/2011/10/php-crontab-class-to-add-and-remove-cron-jobs.html
	public function getCron() {
		$cron = ["raw" => "", "active" => false, "mm" => "", "hh" => "", "dd" => "", "name" => ""];
		$output = shell_exec('crontab -l');
		$lines = explode("\n", trim($output));
		if (count($lines) > 3) { // check cron is not empty - First 3 lines are not cron entry but used to reload crontrab at reboot
			$return['Status'] = "OK";
			while ($lines[0] != "#BEGIN") { array_shift($lines); } //Remove non cron lines
			array_shift($lines);
			foreach ($lines as $entry) {
				$str = explode("/usr", $entry);
				$cron["raw"] = rtrim($str[0]);
				if ($cron["raw"][0] == "#") {
					$cron["active"] = false;
					$sched = substr($cron["raw"],1);
				}
				else {
					$cron["active"] = true;
					$sched = $cron["raw"];
				}
				$sched = explode(" ",$sched);
				$cron["mm"] = $sched[0];
				$cron["hh"] = $sched[1];
				$cron["dd"] = $sched[4];
				$cron["name"] = explode("#",$str[count($str)-1]);
				$cron["name"] = $cron["name"][1];
				$return['cron'][]=$cron;
			}
		}
		else $return['Status'] = "KO";
		if (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1]['function'] == 'invokeMethod') Flight::json($return);
		else return $return;
	}

	// Add a cron etry in www-data crontab
	public function addCron() { // cron parameters passed via JSON query string
		$cron = json_decode(Flight::request()->query['cron'],true);
		$t = explode(":",$cron['t']); //time
		$i= 0;
		$str='';
		foreach ($cron['d'] as $d) { //compose day of Week
			if ($d) $str .= $i.',';
			$i++;
		};
		$str = rtrim($str,',');
		$cronLine = $t[1].' '.$t[0].' * * '.$str.' /usr/bin/curl localhost/radion >/dev/null 2>&1 #'.$cron['c'].PHP_EOL;
		file_put_contents(Flight::get("pathCron"), $cronLine, FILE_APPEND | LOCK_EX);
		exec("cat ".Flight::get("pathCron")." | crontab -");
		Flight::json(array('Status' => 'OK','Cron' => $t[1].' '.$t[0].' * * '.$str.' #'.$cron['c']));
	}

	// Remove cron entry indexed by $cron - start at 0
	public function delCron($cron) {
		$output = shell_exec('crontab -l');
		$lines = explode("\n", trim($output));
		if (count($lines) > 3+$cron) {
			array_splice($lines, 3+$cron, 1);
			$x='';
			foreach ($lines as $line) $x .=$line.PHP_EOL;
			file_put_contents(Flight::get("pathCron"), $x);
			exec("cat ".Flight::get("pathCron")." | crontab -");
			Flight::json(array('Status' => 'OK','Cron' => $cron));
		}
		else Flight::json(array('Status' => 'KO','Cron' => $cron . ' Not Found'));
	}

	// Activate / Desactive cron entry indexed by $cron - start at 0 / $cronState = on|off
	public function stateCron($cron,$cronState) {
		$cronState = strtolower($cronState);
		$output = shell_exec('crontab -l');
		$lines = explode("\n", trim($output));
		if (count($lines) > 3+$cron) {
			$x='';
			while ($lines[0] != "#BEGIN") {
				$x .=$lines[0].PHP_EOL; //copy first header lines of cron file
				array_shift($lines);
			}
			$x .=$lines[0].PHP_EOL; //copy first header lines of cron file
			array_shift($lines);
			$i=0;
			foreach ($lines as $line) {
				if ($i == $cron) {
					if ((substr($line,0,1) == '#' && $cronState == 'off') || (substr($line,0,1) != '#' && $cronState == 'on')) {} // do nothing, cron line is OK
					elseif ((substr($line,0,1) == '#' && $cronState == 'on')) $x .=substr($line,1).PHP_EOL; // uncomment cron line
					elseif ((substr($line,0,1) != '#' && $cronState == 'off')) $x .= '#'.$line.PHP_EOL; //comment cron line
				}
				else $x .=$line.PHP_EOL;
				$i++;
			}
			file_put_contents(Flight::get("pathCron"), $x);
			exec("cat ".Flight::get("pathCron")." | crontab -");
			Flight::json(array('Status' => 'OK','Cron' => $cron,'State'=> $cronState));
		}
		else Flight::json(array('Status' => 'KO','Cron' => $cron . ' Not Found'));
	}

	// Return the next cron time that will be fired
	public function nextCron() {
		$jour=array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
		$x = self::getCron();
		$t = [];
		foreach ($x['cron'] as $cron) {
			if ($cron['active']) $t[] = self::getNextCron($cron['raw']);
		}
		if (count($t) >=1) {
			$n = min($t);
			Flight::json(array('Status' => 'OK','Time' => $jour[date('w', $n)].date(' d/m/Y H:i', $n)));
		}
		else Flight::json(array('Status' => 'KO','Time' => 'Not Found'));
	}
	
	// List scheduled 'at' jobs
	public function getAt() {
		$jour=array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
		$x = shell_exec('atq');
		if (count($x) >= 1) {
			$x = explode("\n",trim($x));
			$atq = [];
			foreach ($x as $at) {
				$at = explode("\t", $at);
				$at[1] = str_replace(' www-data', '', $at[1]);
				$d = substr($at[1],0,-1);
				$ts = strtotime($d);
				$d = $jour[date('w',$ts)].date(' d/m/Y H:i', $ts);
				$atq[] = array('id' => $at[0], 'date' => $d, 'ts' => $ts, 'type' => substr($at[1],-1));
			}
			array_multisort(array_column($atq, 'ts'),$atq);
			Flight::json(array('Status' => 'OK','At' => $atq));
		}
		else Flight::json(array('Status' => 'KO','At' => 'Not Found'));
	}

	// Delete scheduled 'at' jobs indexed by $at (=jobid from atq command)
	public function delAt($at) {
		passthru('atrm '.$at,$x);
		if ($x == 0) Flight::json(array('Status' => 'OK','At' => $at.' Deleted'));
		else Flight::json(array('Status' => 'KO','At' => $at.' Not Found'));
	}

	// Add scheduled 'at' jobs
	public function addAt() {
		$at = json_decode(Flight::request()->query['at'],true);
		$date = date('H:i Y-m-d', $at['d']);
		switch ($at['t']) {
			case 'on': exec('at '.$date.' -q A -f /srv/www/home.fr/public/conf/aton.txt'); break;
			case 'off': exec('at '.$date.' -q B -f /srv/www/home.fr/public/conf/atoff.txt'); break;
			case 'tts': exec('at '.$date.' -q C -f /srv/www/home.fr/public/conf/attts.txt'); break;
		}
		Flight::json(array('Status' => 'OK','At' => $date, 'Type' => $at['t']));
	}

	// Return the NEXT Radio ON trigger for today (HH:MM or --:-- if none) - The trigger can be a cron or a 'at' event
	public function todayOn() {
		// Add all cron timestamp in $t
		$x = self::getCron();
		$t = [];
		foreach ($x['cron'] as $cron) {
			if ($cron['active']) $t[] = self::getNextCron($cron['raw']);
		}
		// Add all at events of type A in $t
		$x = shell_exec('atq');
		if (count($x) >= 1) {
			$x = explode("\n",trim($x));
			foreach ($x as $at) {
				$at = explode("\t", $at);
				$at[1] = str_replace(' www-data', '', $at[1]);
				$d = substr($at[1],0,-1);
				if (substr($at[1],-1) == 'A') { // type audio on
					$t[] = strtotime($d);
				}
			}
		}
		if (count($t) >=1) {
			$t = min($t);
			if (date('Ymd') == date('Ymd', $t)) { // next cron is today
				$str = date("H:i",$t);
			}
			else $str = "--:--";
		}
		else $str = "--:--";
		Flight::json(array('Time' => $str));
	}

	// Holiday mode - disable all "cron" and delete all "At"
	public function holiday() {
		// Disable cron
		$output = shell_exec('crontab -l');
		$lines = explode("\n", trim($output));
		if (count($lines) > 3) {
			$x='';
			while ($lines[0] != "#BEGIN") {
				$x .=$lines[0].PHP_EOL; //copy first header lines of cron file
				array_shift($lines);
			}
			$x .=$lines[0].PHP_EOL; //copy first header lines of cron file
			array_shift($lines);
			foreach ($lines as $line) {
				if (substr($line,0,1) != '#') $x .= '#'.$line.PHP_EOL; //comment cron line
				else $x .= $line.PHP_EOL;
			}
			file_put_contents(Flight::get("pathCron"), $x);
			exec("cat ".Flight::get("pathCron")." | crontab -");
			$ret = array('Status' => 'OK');

		}
		else  { $ret = array('Status' => 'KO','Cron' => 'Not Found'); }
		// del all "At"
		$x = shell_exec('atq');
		if (count($x) >= 1) {
			$x = explode("\n",trim($x));
			foreach ($x as $at) {
				$at = explode("\t", $at);
				passthru('atrm '.$at[0],$x1);
			}
		}
		Flight::json($ret);
	}

	// List stations in playlist
	public function getStation() {
		$stations = @file(Flight::get("pathStation"),FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (count($stations) >=1 && $stations ) {
			foreach ($stations as $station) {
				$station = explode("#",$station);
				$x = explode(' ',$station[0]);
				$entry[] = array('URL'=>rtrim($x[1]),'name'=>ltrim($station[1],"#"),'selected'=> $x[0]);
			}
			Flight::json(array('Status' => "OK", 'station' => $entry));
		}
		else Flight::json(array('Status' => "KO", 'station' => 'Not Found'));
	}

	// Activate station entry indexed by $station - start at 0
	public function selectStation($station) {
		$stations = @file(Flight::get("pathStation"),FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (count($stations) >=1 && $stations ) {
			$i=0;
			$x = [];
			foreach ($stations as $st) {
				if ($station == $i) {$x[] = '1'.substr($st,1);}
				else {$x[] = '0'.substr($st,1);}
				$i++;
			}
			$str = implode("\n", $x);
			file_put_contents(Flight::get("pathStation"), $str);
			// if radio is running, restart it with new station
			if (self::isAudioRunning()) {
				self::stopRadio();
				self::startRadio();
			}
			Flight::json(array('Status' => 'OK','Station' => $station));
		}
		else Flight::json(array('Status' => "KO", 'station' => 'Not Found'));
	}

	// Upload station file
	public function uploadStation() {
		$file = Flight::request()->files;
		$success=move_uploaded_file($file['file']['tmp_name'],Flight::get("pathStation"));
		if ($success) Flight::json(array('Status' => "OK", 'file' => $file['file']['name']));
		else Flight::json(array('Status' => "KO", 'file' => $file['file']['error']));
	}

	// Download station file
	public function downloadStation() {
		$file = Flight::get("pathStation");
		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}
	}

	// Set Volume in range 1 - 100
	public function setVolume($vol) {
		$x = exec("amixer sset Volume $vol%"); // set Volume
		$x = trim(substr($x,-5,3)," ["); //  trim result from exec result "Front Right: 20 [100%]"
		if (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1]['function'] == 'invokeMethod') Flight::json(array('Status' => 'OK', 'Volume' => $x)); // Return JSON only for rest calls
	}

	// Get Volume
	public function getVolume() {
		$x = exec("amixer sget Volume"); // get Volume
		$x = trim(substr($x,-5,3)," ["); //  trim result from exec result "Front Right: 20 [100%]"
		if (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1]['function'] == 'invokeMethod') Flight::json(array('Status' => 'OK', 'Volume' => $x));
		else return $x;
	}

	// Start Radio
	public function startRadio($trig) {
		if (!self::isAudioRunning()) {	// Radio is not running, we can start it
			$station = self::whichStation();  // selected radio in playlist or default radio if no playlist
			$ok = self::checkRadioIsReachable($station); // check radio is reachable
			//$ok = self::checkRadioIsReachable("http://stream.chantefrance.com/stream_chante_france.mp3");
			if ($ok != true) { 
				$station = Flight::get("localStation"); // default to local mp3
			}
			exec("screen -dmS audiorun /usr/bin/mpg123 -q --loop -1 $station");
			if ($trig == 'trig' && Flight::get("callbackJeedomActive")) { $x = file_get_contents(Flight::get("callbackJeedom")); } // Callback Jeedom
			if (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1]['function'] == 'invokeMethod') Flight::json(array('Status' => 'OK', 'Radio' => 'Running', "path" => $station));
		}
		else {
			if (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1]['function'] == 'invokeMethod') Flight::json(array('Status' => 'OK', 'Radio' => 'Was already Running'));
		}
	}
	
	// Stop Radio
	public function stopRadio() {
		exec('screen -p 0 -S audiorun -X kill');
		if (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1]['function'] == 'invokeMethod') Flight::json(array('Status' => 'OK', 'Radio' => 'Stopped'));
	}

	// Snooze Radio - see config.php for snooze delay
	public function snooze() {
		if (self::isAudioRunning()) {
			self::stopRadio();
			$date = date('H:i Y-m-d', strtotime(Flight::get("snooze")));
			exec('at '.$date.' -q A -f /srv/www/home.fr/public/conf/aton.txt');
			Flight::json(array('Status' => 'OK', 'Snooze at' => $date));
		}
		else
			Flight::json(array('Status' => 'KO', 'Snooze at' => 'Radio was not running'));
	}

	// Return if Radio is running or Stopped (API)
	public function statusRadio() {
		if (self::isAudioRunning()) Flight::json(array('Status' => 'OK', 'Radio' => 'Running'));
		else Flight::json(array('Status' => 'OK', 'Radio' => 'Stopped'));
	}

	// Toggle Radio ON/OFF 
	public function toggleRadio() {
		if (self::isAudioRunning()) {
			self::stopRadio();
			Flight::json(array('Status' => 'OK', 'Radio' => 'Stopped'));
		}
		else {
			self::startRadio();
			Flight::json(array('Status' => 'OK', 'Radio' => 'Running'));
		}
	}

	// Play TTS
	public function playTTS($say) {
		if (Flight::get("ttsLocal")) {
			$tts = '/usr/bin/pico2wave -l fr-FR -w /tmp/tts.wav "<pitch level=\'100\'> <speed level=\'85\'>'.$say.'"';
			exec($tts);
		}
		else {
			$voice = Flight::tts()->speech([
				'key' => Flight::get('ttsKey'),
				'hl' => 'fr-fr',
				'src' => $say,
				'r' => '0',
				'c' => 'mp3',
				'f' => '44khz_16bit_stereo',
				'ssml' => 'false',
				'b64' => 'true'
			]);
		}
		if (Flight::get("ttsLocal") || empty($voice['error'])) {	// No error when acquiring tts result
			$radio2Restart=false;
			if (self::isAudioRunning()) {	// Radio is running, need to stop
				self::stopRadio();
				$radio2Restart = true;
			}
			$prevVol = self::getVolume(); 			// Get current Volume
			self::setVolume(Flight::get('ttsVol'));		// Set TTS Volume
			if (Flight::get("ttsLocal")) {
				exec('screen -dmS audiorun /usr/bin/aplay /tmp/tts.wav');
			}
			else {
				file_put_contents('/tmp/tts.mp3', base64_decode($voice['response']));
				exec('screen -dmS audiorun /usr/bin/mpg123 -q /tmp/tts.mp3');
			}
			while (self::isAudioRunning()) {sleep(1);}	//Wait end of TTS player
			self::setVolume($prevVol);			// Restore Volume
			if ($radio2Restart) self::startRadio();		// Restart Radio if this was running before TTS
			Flight::json(array('Status' => 'OK'));
		}
		else Flight::json(array('Status' => 'TTS: '.$voice['error']));
	}
	
	// Return if Radio (or TTS) is running or Stopped
	private function isAudioRunning() {
		$x = shell_exec("screen -ls");
		if (strpos($x, 'audiorun') == false) return false;
		else return true;
	}

	// Return favorite station in playlist, if none, return default station
	private function whichStation() {
		$stations = @file(Flight::get("pathStation"),FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (count($stations) >=1 && $stations ) {
			$x = '';
			foreach ($stations as $st) {
				if (substr($st,0,1) == '1') {
					$x = substr($st,1);
					$x = explode(" #",$x);
					$x = $x[0];
				}
			}
			if ($x == '') {$x = Flight::get("defaultStation");}
		}
		else $x = (Flight::get("defaultStation"));
		return trim($x);
	}

	// Check the Radio stream is OK
	private function checkRadioIsReachable($url) {
		$options = array(
			CURLOPT_CONNECT_ONLY	=> false,
			CURLOPT_FRESH_CONNECT	=> true,
			CURLOPT_FORBID_REUSE	=> true,
			CURLOPT_RETURNTRANSFER	=> false,	// return web page
			CURLOPT_HEADER		=> false,	// don't return headers
			CURLOPT_FOLLOWLOCATION	=> true,	// follow redirects
			CURLOPT_AUTOREFERER	=> true,	// set referer on redirect
			CURLOPT_CONNECTTIMEOUT	=> 1,		// timeout on connect
			CURLOPT_TIMEOUT		=> 1,		// timeout on response
		);
		$ch = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );
		if ($header['http_code'] == 200) return true;
		else return false;
	}

	// Get next cron using Crontab class
	// Requires to convert day of week from 0-6 to 1-7
	// Return next cron timestamp
	private function getNextCron($c) {
		//$c = "30 07 * * 0";
		$c = 'cron '.$c;
		$c = explode(' ',$c);
		$d = explode(',',$c[5]);
		for ($i=0 ; $i<count($d) ; $i++) { array_splice($d, $i, 1, $d[$i]+1); }
		$d = implode(',',$d);
		$c[5] = $d;	
		$c = implode(' ',$c);
		Flight::nextcron()->AddSchedule($c);
		Flight::nextcron()->RebuildCalendar();
		$result = Flight::nextcron()->NextTrigger();
		return $result["ts"];
	}

	// TTS for local weather of the day
	public function ttsWeather() {
		// https://www.prevision-meteo.ch/uploads/pdf/recuperation-donnees-meteo.pdf
		$data = json_decode(file_get_contents(Flight::get("ttsWeather")),true);

		$txt = "Bonjour, voici la météo pour aujourd'hui: Il fait actuellement ".$data['current_condition']['tmp']."°.";
		$txt .= " Les températures sont prévues entre ".$data['fcst_day_0']['tmin']." et ".$data['fcst_day_0']['tmax']."°.";
		$txt .= " Conditions actuelles: ".$data['current_condition']['condition'].", Conditions pour la journée: ".$data['fcst_day_0']['condition'];
		self::playTTS($txt);
	}

	// TTS from Jeedom interaction answer
	public function ttsJeedom() {
		self::playTTS(file_get_contents(Flight::get("ttsJeedom")));
	}

	// String Saint du jour
	private function getTodayEphemeris() {
		$x = file_get_contents('/srv/www/home.fr/public/conf/ephemeris.json');
		$x = json_decode($x,true);
		$x = $x[date('F')][date('j')-1][1].' '.$x[date('F')][date('j')-1][0];
		return $x;
	}
}
