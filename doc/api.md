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
<td>//setvol/@id</td>
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
<tr>
<td>Note</td>
<td>Volume is set permanent even after a shutdown</td>
</tr>
</tbody>
</table>
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
</table><h2 id="titre-de-niveau-2">Titre de niveau 2</h2>
<p>GET /setvol/@id:[1-9][0-9]?|100</p>
<h1 id="titre-de-niveau-1">Titre de niveau 1</h1>
<p>GET /radion<br>
GET /radioff<br>
GET /snooze<br>
GET /radiostate<br>
GET /radiotoggle</p>
<h1 id="titre-de-niveau-1-1">Titre de niveau 1</h1>
<p>GET /tts/@say<br>
GET /weather<br>
GET /jeedom</p>
<h1 id="titre-de-niveau-1-2">Titre de niveau 1</h1>
<p>GET /getcron<br>
GET /addcron<br>
GET /delcron/@id:[0-9][0-9]*<br>
GET /stacron/@id:[0-9][0-9]*/@state:on|off<br>
GET /nextcron</p>
<h1 id="titre-de-niveau-1-3">Titre de niveau 1</h1>
<p>GET /getat<br>
GET /addat<br>
GET /delat/@id:[1-9][0-9]*</p>
<h1 id="titre-de-niveau-1-4">Titre de niveau 1</h1>
<p>GET /getstation<br>
GET /selstation/@id:[0-9][0-9]*<br>
POST /upload<br>
GET /download</p>

