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
<pre>
{
  <a href="#average_speed">"about_string"</a>: "Developer of ECRanked",
  <a href="#average_speed">"average_speed"</a>: 1.6421,
  <a href="#average_ping">"average_ping"</a>: 64.626,
  <a href="#percent_stopped">"percent_stopped"</a>: 0.291188,
  <a href="#percent_upsidedown">"percent_upsidedown"</a>: 0.023962,
  <a href="#total_games">"total_games"</a>: 50,
  <a href="#total_deaths">"total_deaths"</a>: 344,
  <a href="#average_deaths">"average_deaths"</a>: 6.88,
  <a href="#discord_name">"discord_name"</a>: "BiffBish",
  <a href="#discord_pfp">"discord_pfp"</a>: "https://cdn.discordapp.com/avatars/301343234108424192/788a06ff1b8e6e324f879948081376e2.png",
  <a href="#loadout">"loadout"</a>: {
    "0": 0.000594,
    "1": 0.000045,
    "2": 0.0,
    ...
    "62": 0.400121,
    "63": 0.0
  },
  <a href="#top_loadout">"top_loadout"</a>: [
    [
      "33",
      0.396773
    ],
    [
      "35",
      0.291986
    ],
    [60 more...],
    [
      "62",
      0.0
    ],
    [
      "63",
      0.0
    ]
  ]
}
</pre>
<h4>
	<a id="about_string" class="anchor" href="#about_string"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>about_string</code>
</h4>
<p>The string that is used in the about me section.</p>
<ul>
	<li>null - There is no about me string</li>
</ul>
<h4>
	<a id="average_speed" class="anchor" href="#average_speed"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>average_speed</code>
</h4>
<p>The average speed of the player measured in meters per second.</p>
<h4>
	<a id="average_ping" class="anchor" href="#average_ping"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>average_ping</code>
</h4>
<p>The average ping of the player measured in milliseconds.</p>
<h4>
	<a id="percent_stopped" class="anchor" href="#percent_stopped"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>percent_stopped</code>
</h4>
<p>The percentage of time the player is "stopped".</p>
<h4>
	<a id="percent_upsidedown" class="anchor" href="#percent_upsidedown"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>percent_upsidedown</code>
</h4>
<p>The percentage of time the player is "upside-down".</p>
<h4>
	<a id="total_games" class="anchor" href="#total_games"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>total_games</code>
</h4>
<p>The total number of games the player has played in.</p>
<h4>
	<a id="total_deaths" class="anchor" href="#total_deaths"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>total_deaths</code>
</h4>
<p>The total number of times the player has died.</p>
<h4>
	<a id="average_deaths" class="anchor" href="#average_deaths"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>average_deaths</code>
</h4>
<p>The average number of deaths per game.</p>
<h4>
	<a id="discord_name" class="anchor" href="#discord_name"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>discord_name</code>
</h4>
<p>The discord username of the person if they have linked their discord account.</p>
<ul>
	<li>null - The discord is not linked</li>
</ul>
<h4>
	<a id="discord_pfp" class="anchor" href="#discord_pfp"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>discord_pfp</code>
</h4>
<p>The discord profile picture of the person if they have linked their discord account.</p>
<ul>
	<li>null - The discord is not linked</li>
</ul>
<h4>
	<a id="loadout" class="anchor" href="#loadout"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>loadout{}</code>
</h4>
<p>A dictionary of loadouts and percentage of frames they were in used in. The loadouts are stored via numbers in a <a
		href="#bitmaps"> bitmap </a></p>
<h4>
	<a id="top_loadout" class="anchor" href="#top_loadout"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>top_loadout[]</code>
</h4>
<p>A list of the persons top loadouts sorted from greatest to lowest</p>
<h4>
	<a id="top_loadout0" class="anchor" href="#top_loadout0"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>top_loadout.[0]</code>
</h4>
<p>The loadout number in string form.</p>
<h4>
	<a id="top_loadout1" class="anchor" href="#top_loadout1"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>top_loadout.[1]</code>
</h4>
<p>The percentage of time it has been used.</p>
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
  <a href="#players">"players"</a>: [
    {
      <a href="#playersteam">"team"</a>: 0,
      <a href="#playersplayerid">"playerid"</a>: 0,
      <a href="#playersname">"name"</a>: "GE0-_",
      <a href="#playersuserid">"userid"</a>: 2719646711436186,
      <a href="#playersnumber">"number"</a>: 22,
      <a href="#playerslevel">"level"</a>: 9,
      <a href="#playersstartFrame">"startFrame"</a>: 0,
      <a href="#playersstats">"stats"</a>: {
        <a href="#playersstatstotal_frames">"total_frames"</a>: 19029,
        <a href="#playersstatstotal_ping">"total_ping"</a>: 1797145,
        <a href="#playersstatstotal_speed">"total_speed"</a>: 42329.234783699496,
        <a href="#playersstatsframes_speed">"frames_speed"</a>: 15530,
        <a href="#playersstatstotal_upsidedown">"total_upsidedown"</a>: 10640,
        <a href="#playersstatsframes_upsidedown">"frames_upsidedown"</a>: 15530,
        <a href="#playersstatstotal_stopped">"total_stopped"</a>: 5289,
        <a href="#playersstatsframes_stopped">"frames_stopped"</a>: 15530,
        <a href="#playersstatstotal_deaths">"total_deaths"</a>: 3,
        <a href="#playersstatstotal_deaths">"loadout"</a>: {
          "0": 1012,
          "1": 18017,
          ...
          "62": 0,
          "63": 0
        },
        "frames_loadout": 19029
      }
    },
  [players.....]
  ]
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
<h4>
	<a id="playersplayerid" class="anchor" href="#playersplayerid"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].playerid</code>
</h4>
<p>The player ID of the player.</p>
<ul>
	<li>unique per game</li>
</ul>
<h4>
	<a id="playersname" class="anchor" href="#playersname"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].name</code>
</h4>
<p>The name of the player.</p>
<h4>
	<a id="playersuserid" class="anchor" href="#playersuserid"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].userid</code>
</h4>
<p>The Oculus ID of the player.</p>
<h4>
	<a id="playersnumber" class="anchor" href="#playersnumber"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].number</code>
</h4>
<p>The number of the player.</p>
<ul>
	<li>not unique</li>
</ul>
<h4>
	<a id="playerslevel" class="anchor" href="#playerslevel"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].level</code>
</h4>
<p>The combat level of the player.</p>
<h4>
	<a id="playersstartframe" class="anchor" href="#playersstartframe"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].startFrame</code>
</h4>
<p>The frame the player joined the match.</p>
<h4>
	<a id="playersstats" class="anchor" href="#playersstats"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats</code>
</h4>
<p>Dictionary of statistics for the player for that game</p>
<h4>
	<a id="playersstatstotal_frames" class="anchor" href="#playersstatstotal_frames"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.total_frames</code>
</h4>
<p>Total number of frames the player was in the game.</p>
<h4>
	<a id="playersstatstotal_ping" class="anchor" href="#playersstatstotal_ping"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.total_ping</code>
</h4>
<p>Players ping added up for all total frames.</p>
<h4>
	<a id="playersstatstotal_speed" class="anchor" href="#playersstatstotal_speed"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.total_speed</code>
</h4>
<p>Players speed (m/s) added up for tracked frames.</p>
<h4>
	<a id="playersstatsframes_speed" class="anchor" href="#playersstatsframes_speed"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.frames_speed</code>
</h4>
<p>Number of frames the player is not in the spawn room and not traveling under 1m/s.</p>
<h4>
	<a id="playersstatstotal_upsidedown" class="anchor" href="#playersstatstotal_upsidedown"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.total_upsidedown</code>
</h4>
<p>Number of frames the players head is flipped upside-down while tracked</p>
<h4>
	<a id="playersstatsframes_upsidedown" class="anchor" href="#playersstatsframes_upsidedown"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.frames_upsidedown</code>
</h4>
<p>Number of frames the player is not in the spawn room</p>
<h4>
	<a id="playersstatstotal_stopped" class="anchor" href="#playersstatstotal_stopped"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.total_stopped</code>
</h4>
<p>Number of frames the player is traveling under 1m/s while tracked</p>
<h4>
	<a id="playersstatsframes_stopped" class="anchor" href="#playersstatsframes_stopped"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.frames_stopped</code>
</h4>
<p>Number of frames the player is not in the spawn room</p>
<h4>
	<a id="playersstatstotal_deaths" class="anchor" href="#playersstatstotal_deaths"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.total_deaths</code>
</h4>
<p>Number of deaths of the player</p>
<h4>
	<a id="playersstatsloadout" class="anchor" href="#playersstatsloadout"
		aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a><code>players[].stats{}.loadout</code>
</h4>
<p>A dictionary of loadouts and how many frames they were in use. The loadouts are stored via numbers in a <a
		href="#bitmaps"> bitmap </a></p>
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
<p>On a fail the API will return an error message along with a 404 status code. The error message is
	<code>There is no user with that username</code> for /user and <code>session id not found</code> for /replay</p>
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

</html>