---


---

<h1 id="home-automation-audio-satellite-api-documentation">Home automation Audio Satellite API Documentation</h1>
<ul>
<li><a href="https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-global-volume">Manage global volume</a></li>
<li><a href="https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-web-radio">Manage Web Radio</a></li>
<li><a href="https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-text-to-speech-tts">Manage Text-to-speech (TTS)</a></li>
<li><a href="https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-alarm-clock-scheduler-recurring">Manage alarm clock scheduler (recurring)</a></li>
<li><a href="https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-alarm-clock-scheduler-non-recurring">Manage alarm clock scheduler (non recurring)</a></li>
<li><a href="https://github.com/diving91/web-radio/blob/master/doc/api.md#manage-web-radio-playlist">Manage Web Radio Playlist</a></li>
</ul>
<h1 id="embedded-app">Embedded app</h1>

<table>
<thead>
<tr>
<th>Description</th>
<th>Local application</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>None</td>
</tr>
<tr>
<td>Success</td>
<td>Render server hosted application</td>
</tr>
<tr>
<td>Error</td>
<td>none</td>
</tr>
</tbody>
</table><h1 id="manage-global-volume">Manage global volume</h1>

<table>
<thead>
<tr>
<th>Description</th>
<th>Set current audio volume (1-100)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/setvol/@id</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”,“Volume”:“24”}</td>
</tr>
<tr>
<td>Error</td>
<td>{“Status”:“KO”,“Volume”:“Out of Range”}</td>
</tr>
<tr>
<td>Note</td>
<td>Volume is set permanent even after a shutdown/reboot</td>
</tr>
<tr>
<td>Example</td>
<td>/setvol/50</td>
</tr>
</tbody>
</table><h2 id="section"></h2>

<table>
<thead>
<tr>
<th>Description</th>
<th>Get current audio volume (1-100)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/getvol</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”,“Volume”:“24”}</td>
</tr>
<tr>
<td>Error</td>
<td>none</td>
</tr>
</tbody>
</table><h1 id="manage-web-radio">Manage Web Radio</h1>

<table>
<thead>
<tr>
<th>Description</th>
<th>Turn Web Radio ON</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/radion</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”,“Radio”:“Running”,“path”:“http://stream_url.mp3”}</td>
</tr>
<tr>
<td></td>
<td>{“Status”:“OK”,“Radio”:“Was already Running”}</td>
</tr>
<tr>
<td>Error</td>
<td>none</td>
</tr>
<tr>
<td>Note</td>
<td>Stream the Selected Radio in Playlist</td>
</tr>
<tr>
<td></td>
<td>If no playlist, stream default Radio (server side configured)</td>
</tr>
<tr>
<td></td>
<td>If radio stream is not reachable, plays a local file (server side configured)</td>
</tr>
</tbody>
</table><h2 id="section-1"></h2>

<table>
<thead>
<tr>
<th>Description</th>
<th>Turn Web Radio OFF</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/radioff</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”,“Radio”:“Stopped”}</td>
</tr>
<tr>
<td>Error</td>
<td>none</td>
</tr>
<tr>
<td>Note</td>
<td>It also turns off running TTS stream</td>
</tr>
</tbody>
</table><h2 id="section-2"></h2>

<table>
<thead>
<tr>
<th>Description</th>
<th>Snooze Web Radio</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/snooze</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”,“Snooze at”:“HH:MM YYYY-MM-DD”}</td>
</tr>
<tr>
<td>Error</td>
<td>{“Status”:“KO”,“Snooze at”:“Radio was not running”}</td>
</tr>
<tr>
<td>Note</td>
<td>Snooze time is server side configured</td>
</tr>
</tbody>
</table><h2 id="section-3"></h2>

<table>
<thead>
<tr>
<th>Description</th>
<th>Return Web Radio status</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/radiostate</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”,“Radio”:“Running”}</td>
</tr>
<tr>
<td></td>
<td>{“Status”:“OK”,“Radio”:“Stopped”}</td>
</tr>
<tr>
<td>Error</td>
<td>none</td>
</tr>
</tbody>
</table><h2 id="section-4"></h2>

<table>
<thead>
<tr>
<th>Description</th>
<th>Toggle Web Radio ON/OFF</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/radiotoggle</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”,“Radio”:“Running”}</td>
</tr>
<tr>
<td></td>
<td>{“Status”:“OK”,“Radio”:“Stopped”}</td>
</tr>
<tr>
<td>Error</td>
<td>none</td>
</tr>
</tbody>
</table><h2 id="manage-text-to-speech-tts">Manage Text-to-speech (TTS)</h2>

<table>
<thead>
<tr>
<th>Description</th>
<th>Play a Text-to-Speed voice (VoiceRSS or picoTTS)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/tts/@say</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”}</td>
</tr>
<tr>
<td>Error</td>
<td>{“Status”:“TTS: #Error date from VoiceRSS#”}</td>
</tr>
<tr>
<td>Example</td>
<td>/tts/Hello%20World!</td>
</tr>
<tr>
<td>Note</td>
<td>TTS engine is server side configured</td>
</tr>
<tr>
<td></td>
<td>picoTTS does not required web service, it runs locally</td>
</tr>
<tr>
<td></td>
<td>TTS play volume is server side configured</td>
</tr>
<tr>
<td></td>
<td>If a Web Radio was running, it is stopped for TTS, then restarted automatically</td>
</tr>
</tbody>
</table><h2 id="section-5"></h2>

<table>
<thead>
<tr>
<th>Description</th>
<th>Play a preconfigured weather information</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/weather</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>“Status”:“OK”</td>
</tr>
<tr>
<td>Error</td>
<td>{“Status”:“TTS: #Error date from VoiceRSS#”}</td>
</tr>
<tr>
<td>Note</td>
<td>Use a web service from <a href="https://www.prevision-meteo.ch">https://www.prevision-meteo.ch</a></td>
</tr>
<tr>
<td></td>
<td>Actual temperature, min/max temperature for today</td>
</tr>
<tr>
<td></td>
<td>Actual weather condition, Today weather condition</td>
</tr>
</tbody>
</table><h2 id="section-6"></h2>

<table>
<thead>
<tr>
<th>Description</th>
<th>Play an interaction result from Jeedom home automation system</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>URL</strong></td>
<td><strong>/jeedom</strong></td>
</tr>
<tr>
<td>Method</td>
<td>GET</td>
</tr>
<tr>
<td>URL params</td>
<td>none</td>
</tr>
<tr>
<td>Success</td>
<td>“Status”:“OK”</td>
</tr>
<tr>
<td>Error</td>
<td>{“Status”:“TTS: #Error date from VoiceRSS#”}</td>
</tr>
<tr>
<td>Note</td>
<td>Uses Interaction system from <a href="http://jeedom.fr">http://jeedom.fr</a></td>
</tr>
<tr>
<td></td>
<td>calls jeedom API with a server side predefined query and play back result using TTS</td>
</tr>
<tr>
<td></td>
<td>This can be used with a non recurring alarm clock trigger</td>
</tr>
<tr>
<td></td>
<td>Typical use case: Jeedom query (<strong>/nextcron</strong>) the next wake up time every day at 00:00 and set (<strong>/addat</strong>) a non recurring wake-up time at  Web Radio wake up time +xx minutes to render interaction result</td>
</tr>
</tbody>
</table><br>
<br>
<div class="mermaid"><svg xmlns="http://www.w3.org/2000/svg" id="mermaid-svg-JJGcyQtviGJ4xf1J" height="100%" width="100%" style="max-width:550px;" viewBox="-50 -10 550 582"><g></g><g><line id="actor1222" x1="75" y1="5" x2="75" y2="571" class="actor-line" stroke-width="0.5px" stroke="#999"></line><rect x="0" y="0" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="75" y="32.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="75" dy="0">Jeedom</tspan></text></g><g><line id="actor1223" x1="275" y1="5" x2="275" y2="571" class="actor-line" stroke-width="0.5px" stroke="#999"></line><rect x="200" y="0" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="275" y="32.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="275" dy="0">Audio Satellite</tspan></text></g><defs><marker id="arrowhead" refX="5" refY="2" markerWidth="6" markerHeight="4" orient="auto"><path d="M 0,0 V 4 L6,2 Z"></path></marker></defs><defs><marker id="crosshead" markerWidth="15" markerHeight="8" orient="auto" refX="16" refY="4"><path fill="black" stroke="#000000" style="stroke-dasharray: 0, 0;" stroke-width="1px" d="M 9,2 V 6 L16,4 Z"></path><path fill="none" stroke="#000000" style="stroke-dasharray: 0, 0;" stroke-width="1px" d="M 0,1 L 6,7 M 6,1 L 0,7"></path></marker></defs><g><text x="175" y="93" style="text-anchor: middle;" class="messageText">at 00:00 : next cron?</text><line x1="75" y1="100" x2="275" y2="100" class="messageLine0" stroke-width="2" stroke="black" style="fill: none;" marker-end="url(#arrowhead)"></line></g><g><text x="175" y="128" style="text-anchor: middle;" class="messageText">20:00 2018-04-11</text><line x1="275" y1="135" x2="75" y2="135" style="stroke-dasharray: 3, 3; fill: none;" class="messageLine1" stroke-width="2" stroke="black" marker-end="url(#arrowhead)"></line></g><g><text x="175" y="163" style="text-anchor: middle;" class="messageText">/addat?at= 20:03 2018-04-11 TTS</text><line x1="75" y1="170" x2="275" y2="170" class="messageLine0" stroke-width="2" stroke="black" style="fill: none;" marker-end="url(#arrowhead)"></line></g><g><text x="275" y="198" style="text-anchor: middle;" class="messageText">Wait</text><path d="M 275,205 C 335,195 335,235 275,225" class="messageLine0" stroke-width="2" stroke="black" style="fill: none;" marker-end="url(#arrowhead)"></path></g><g><rect x="300" y="245" fill="#EDF2AE" stroke="#666" width="150" height="81" rx="0" ry="0" class="note"></rect><text x="316" y="275" fill="black" class="noteText"><tspan x="316">Wake-up time at</tspan><tspan dy="23" x="316">20:00 (Start Web</tspan><tspan dy="23" x="316">Radio)</tspan></text></g><g><text x="175" y="354" style="text-anchor: middle;" class="messageText">at 20:03 2018-04-11 : Jeedom interaction query</text><line x1="275" y1="361" x2="75" y2="361" class="messageLine0" stroke-width="2" stroke="black" style="fill: none;" marker-end="url(#arrowhead)"></line></g><g><text x="175" y="389" style="text-anchor: middle;" class="messageText">Interaction result</text><line x1="75" y1="396" x2="275" y2="396" style="stroke-dasharray: 3, 3; fill: none;" class="messageLine1" stroke-width="2" stroke="black" marker-end="url(#arrowhead)"></line></g><g><rect x="300" y="406" fill="#EDF2AE" stroke="#666" width="150" height="35" rx="0" ry="0" class="note"></rect><text x="316" y="436" fill="black" class="noteText"><tspan x="316" fill="black">TTS at 20:03</tspan></text></g><g><rect x="300" y="451" fill="#EDF2AE" stroke="#666" width="150" height="35" rx="0" ry="0" class="note"></rect><text x="316" y="481" fill="black" class="noteText"><tspan x="316" fill="black">Web Radio restart</tspan></text></g><g><rect x="0" y="506" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="75" y="538.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="75" dy="0">Jeedom</tspan></text></g><g><rect x="200" y="506" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="275" y="538.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="275" dy="0">Audio Satellite</tspan></text></g></svg></div>
<h2 id="manage-alarm-clock-scheduler-recurring">Manage alarm clock scheduler (recurring)</h2>
<p>GET /getcron<br>
GET /addcron<br>
GET /delcron/@id:[0-9][0-9]*<br>
GET /stacron/@id:[0-9][0-9]*/@state:on|off<br>
GET /nextcron</p>
<h2 id="manage-alarm-clock-scheduler-non-recurring">Manage alarm clock scheduler (non recurring)</h2>
<p>GET /getat<br>
GET /addat<br>
GET /delat/@id:[1-9][0-9]*</p>
<p>addat?at={%22d%22:1523823600,%22t%22:%22tts%22}<br>
addat?at={“d”:1523823600,“t”:“tts”}</p>
<h2 id="manage-web-radio-playlist">Manage Web Radio Playlist</h2>
<p>GET /getstation<br>
GET /selstation/@id:[0-9][0-9]*<br>
POST /upload<br>
GET /download</p>

