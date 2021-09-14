<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>api_docs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/md.css">

</head>

<body>
<a href="/home">Home</a>



<h1>
	<a id="ecstats_api_docs" class="anchor" href="#ecstats_api_docs"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>ECStats_api_docs</h1>
<p>Official documentation for Echo VR's unofficial Combat Stat Tracker.</p>
<h2>
	<a id="summary" class="anchor" href="#summary"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Summary</h2>
<p>Echo Combat Stats (ECStats) has a public API available from their website. If a user query is
	<code>http://ecranked.ddns.net/user/Timemaster111/stats</code> then the API query is
	<code>http://ecranked.ddns.net/user/Timemaster111/stats.json</code>.</p>
<p>Similarly, a game/replay query is <code>http://ecranked.ddns.net/replay/5D833913-11FA-4A1E-8E33-4CB9A173C201</code>
	and the API is from <code>http://ecranked.ddns.net/replay/5D833913-11FA-4A1E-8E33-4CB9A173C201.json</code>.</p>
<h2>
	<a id="api-endpoints" class="anchor" href="#api-endpoints"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>API Endpoints</h2>
<p>The endpoints mirror the website, so the user endpoints are <code>/user/&lt;USER&gt;/stats.json</code> and the
	game/replay enpoints are <code>/replay/&lt;REPLAY-ID&gt;.json</code>.</p>
<h3>
	<a id="get-user" class="anchor" href="#get-user"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>GET /user</h3>
<h4>
	<a id="example-response" class="anchor" href="#example-response"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Example Response</h4>
<h3>
	<a id="get-replay" class="anchor" href="#get-replay"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>GET /replay</h3>
<h4>
	<a id="example-response-1" class="anchor" href="#example-response-1"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Example Response</h4>
<pre>
{
  <a href="#frames">"frames"</a>: 19029,
  <a href="#start_time">"start_time"</a>: "2021-09-12 20:20:19.02",
  <a href="#end_time">"end_time"</a>: "2021-09-12 20:24:57.34",
  <a href="#match_length">"match_length"</a>: 278,
  <a href="#framerate">"framerate"</a>: 68.44964028776978,
  <a href="#map">"map"</a>: "surge",
  <a href="#players">"players"</a>: {
    "GE0-_": {
      <a href="#team">"team"</a>: 0,
      <a href="#playerid">"playerid"</a>: 0,
      <a href="#name">"name"</a>: "GE0-_",
      <a href="#userid">"userid"</a>: 2719646711436186,
      <a href="#number">"number"</a>: 22,
      <a href="#level">"level"</a>: 9,
      <a href="#startFrame">"startFrame"</a>: 0,
      <a href="#stats">"stats"</a>: {
        <a href="#total_frames">"total_frames"</a>: 19029,
        "total_ping": 1797145,
        "total_speed": 42329.234783699496,
        "frames_speed": 15530,
        "total_upsidedown": 10640,
        "frames_upsidedown": 15530,
        "total_stopped": 5289,
        "frames_stopped": 15530,
        "total_deaths": 3,
        "loadout": {
          "0": 0,
          "1": 0,
          "2": 0,
          "3": 0,
          "4": 0,
          "5": 0,
          "6": 0,
          "7": 19029,
          "8": 0,
          "9": 0,
          "10": 0,
          "11": 0,
          "12": 0,
          "13": 0,
          "14": 0,
          "15": 0,
          "16": 0,
          "17": 0,
          "18": 0,
          "19": 0,
          "20": 0,
          "21": 0,
          "22": 0,
          "23": 0,
          "24": 0,
          "25": 0,
          "26": 0,
          "27": 0,
          "28": 0,
          "29": 0,
          "30": 0,
          "31": 0,
          "32": 0,
          "33": 0,
          "34": 0,
          "35": 0,
          "36": 0,
          "37": 0,
          "38": 0,
          "39": 0,
          "40": 0,
          "41": 0,
          "42": 0,
          "43": 0,
          "44": 0,
          "45": 0,
          "46": 0,
          "47": 0,
          "48": 0,
          "49": 0,
          "50": 0,
          "51": 0,
          "52": 0,
          "53": 0,
          "54": 0,
          "55": 0,
          "56": 0,
          "57": 0,
          "58": 0,
          "59": 0,
          "60": 0,
          "61": 0,
          "62": 0,
          "63": 0
        },
        "frames_loadout": 19029
      }
    },
[players.....]
}
}
</pre>
<h4>
	<a id="frames" class="anchor" href="#frames"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>frames</code>
</h4>
<p>Total number of frames the bot recorded from the game.</p>
<h4>
	<a id="start_time" class="anchor" href="#start_time"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>start_time</code>
</h4>
<p>The time the bot started recording in GMT/UTC in ISO format.</p>
<h4>
	<a id="end_time" class="anchor" href="#end_time"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>end_time</code>
</h4>
<p>The time the bot stopped recording in GMT/UTC in ISO format.</p>
<h4>
	<a id="match_length" class="anchor" href="#match_length"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>match_length</code>
</h4>
<p>Number of seconds the match was recorded for.</p>
<h4>
	<a id="framerate" class="anchor" href="#framerate"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>framerate</code>
</h4>
<p>The frames per second the bot recorded at.</p>
<h4>
	<a id="map" class="anchor" href="#map"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>map</code>
</h4>
<p>The map the game was played on.</p>
<h4>
	<a id="players" class="anchor" href="#players"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players</code>
</h4>
<p>Players that were in the game.</p>
<h4>
	<a id="playersteam" class="anchor" href="#playersteam"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players{}.team</code>
</h4>
<p>Team the player was on.</p>
<ul>
	<li>0 - Team Blue(?)</li>
	<li>1 - Team Orange(?)</li>
	<li>2 - Spectator</li>
</ul>
<h2>
	<a id="responses" class="anchor" href="#responses"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Responses</h2>
<h3>
	<a id="success" class="anchor" href="#success"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Success</h3>
<p>On a success the API will return a JSON with the data.</p>
<h3>
	<a id="fail" class="anchor" href="#fail"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Fail</h3>
<p>On a fail the API will return an error message. This is <code>There is no user with that username</code> for /user
	and <code>session id not found</code> for /replay</p>
<h2>
	<a id="concepts" class="anchor" href="#concepts"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Concepts</h2>
<h3>
	<a id="bitmaps" class="anchor" href="#bitmaps"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Bitmaps</h3>
<p>The loadouts are stored as bitmaps.</p>
<p>A bitmap is a set of bits where each bit or section of bits represents a value.</p>
<p>In the case of this API, the bitmap translates as follows:</p>
<table>
	<thead>
		<tr>
			<th>X</th>
			<th>00</th>
			<th>00</th>
			<th>00</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>representation</td>
			<td>weapon</td>
			<td>ordnance</td>
			<td>tac mod</td>
		</tr>
		<tr>
			<td>00</td>
			<td>Pulsar</td>
			<td>Detonator</td>
			<td>Repair Matrix</td>
		</tr>
		<tr>
			<td>01</td>
			<td>Nova</td>
			<td>Stun Field</td>
			<td>Threat Scanner</td>
		</tr>
		<tr>
			<td>10</td>
			<td>Comet</td>
			<td>Arc Mine</td>
			<td>Energy Barrier</td>
		</tr>
		<tr>
			<td>11</td>
			<td>Meteor</td>
			<td>Instant Repair</td>
			<td>Phase Shift</td>
		</tr>
	</tbody>
</table>
<p>So a code of 010011 would be a Nova, Detonator and Phase Shift.</p>
<h3>
	<a id="total-and-frames" class="anchor" href="#total-and-frames"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Total and Frames</h3>
<p>Total** refers to the total number of frames in which the stat (*) has been tracked, and Frames** is the number of
	frames this stat is true for.</p>

    /body>
</html>