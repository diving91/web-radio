<h1 id="home-automation-audio-satellite-api-documentation">Home automation Audio Satellite API Documentation</h1>
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
<td>URL:</td>
<td><strong>/</strong></td>
</tr>
<tr>
<td>Methods:</td>
<td>GET</td>
</tr>
<tr>
<td>URL params:</td>
<td>None</td>
</tr>
<tr>
<td>Success</td>
<td>Render hosted apps</td>
</tr>
<tr>
<td>Error</td>
<td>none</td>
</tr>
</tbody>
</table><h1 id="manage-global-volume">Manage Global volume</h1>

<table>
<thead>
<tr>
<th>Description</th>
<th>Set current audio volume (1-100)</th>
</tr>
</thead>
<tbody>
<tr>
<td>URL</td>
<td>/setvol/@id</td>
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
<td>Volume is set permanent even after a shutdown</td>
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
<td>URL</td>
<td>/getvol</td>
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
<td>URL</td>
<td>/radion</td>
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
<td>{“Status”:“OK”,“Radio”:“Running”,“path”:“<a href="http://stream1.chantefrance.com/stream_chante_france.mp3">http://stream1.chantefrance.com/stream_chante_france.mp3</a>”}</td>
</tr>
<tr>
<td>Success</td>
<td>{“Status”:“OK”,“Radio”:“Was already Running”}</td>
</tr>
<tr>
<td>Error</td>
<td>none</td>
</tr>
<tr>
<td>Note</td>
<td>Stream Selected Radio in the Playlist<code>&lt;br&gt;</code>if no playlist, stream default Radio</td>
</tr>
<tr>
<td></td>
<td>if no playlist, stream default Radio</td>
</tr>
<tr>
<td></td>
<td>if stream is not reachable, play a local file</td>
</tr>
</tbody>
</table><p>GET /radion</p>
<h2 id="section-1"></h2>
<p>GET /radioff</p>
<h2 id="section-2"></h2>
<p>GET /snooze</p>
<h2 id="section-3"></h2>
<p>GET /radiostate</p>
<h2 id="section-4"></h2>
<p>GET /radiotoggle</p>
<h1 id="titre-de-niveau-1">Titre de niveau 1</h1>
<p>GET /tts/@say<br>
GET /weather<br>
GET /jeedom</p>
<h1 id="titre-de-niveau-1-1">Titre de niveau 1</h1>
<p>GET /getcron<br>
GET /addcron<br>
GET /delcron/@id:[0-9][0-9]*<br>
GET /stacron/@id:[0-9][0-9]*/@state:on|off<br>
GET /nextcron</p>
<h1 id="titre-de-niveau-1-2">Titre de niveau 1</h1>
<p>GET /getat<br>
GET /addat<br>
GET /delat/@id:[1-9][0-9]*</p>
<h1 id="titre-de-niveau-1-3">Titre de niveau 1</h1>
<p>GET /getstation<br>
GET /selstation/@id:[0-9][0-9]*<br>
POST /upload<br>
GET /download</p>

