<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Red Kitty</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" href="/css/global.css" type="text/css" class="stylesheet" media="screen, projection" />
</head>
<body>
<div id="global-header-shell">
	<div id="global-header">
		<div id="txt-logo"><a href="/kitty/">RED<span>Kitty</span></a></div>
		<ul id="control">
			<li class="no-dash"><a href="/kitty/" class="current">Server</a></li>
			<li><a href="/kitty/info">Statistics</a></li>
			<li><a class="settings" href="/kitty/console">Console</a></li>
		</ul>
		<div class="fclear"></div>
	</div>
</div>

<div id="global-navigation-shell">
	<div id="global-navigation">
		<ul id="menu">
			<li class="no-dash"><a href="/kitty/" class="current">DBs:</a></li>
			<?php foreach($ro['dbs'] as $ditem): ?>
			<li><a href="/kitty/server/db<?php echo $ditem['db']; ?>"<?php echo (($ditem['db']==$ro['server'])?' class="current"':''); ?>>DB#<?php echo $ditem['db']; ?> (<?php echo $ditem['keys']; ?>)</a></li>				
			<?php endforeach ?>
		</ul>
		<div class="fclear"></div>
	</div>
</div>

<div class="global-shell">
	<div class="widget-shell tabbing inner-shadow">
		<div class="widget-header">
			<h2>
				<div style="display:inline;">Server description</div>
			</h2>
		</div>
		<div class="arts">
			<table>
				<tbody>
				<?php $i=0; ?>
				<?php foreach($ro['dbs'] as $ditem): ?>
				<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
					<td>
						<p>
							<b class="space"><img src="/img/space.png"/></b>
							<a style="background-color:#407fbf;" href="/kitty/server/db<?php echo $ditem['db']; ?>/">DB#<?php echo $ditem['db']; ?></a>&nbsp;&nbsp;
							<a style="background-color:#89a118;" href="/kitty/server/db<?php echo $ditem['db']; ?>/">keys: <?php echo $ditem['keys']; ?></a>&nbsp;&nbsp;
							<a style="background-color:#e7a52a;" href="/kitty/server/db<?php echo $ditem['db']; ?>/">expires: <?php echo $ditem['expires']; ?></a>
						</p>
					</td>
				</tr>
				<?php endforeach ?>
				<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
					<td>
						<p>
							<b class="space"><img src="/img/space.png"/></b>
							<a href="/kitty/#">version: <?php echo $ro['version']; ?></a>
						</p>
					</td>
				</tr>
				<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
					<td>
						<p>
							<b class="space"><img src="/img/space.png"/></b>
							<a href="/kitty/#">last save: <?php echo date("Y-m-d H:i:s", $ro['last_save']); ?></a>
						</p>
					</td>
				</tr>
				<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
					<td>
						<p>
							<b class="space"><img src="/img/space.png"/></b>
							<a href="/kitty/#">uptime: <?php echo $ro['uptime']; echo plural($ro['uptime'], 'day', 'days', 'days'); ?></a>
						</p>
					</td>
				</tr>
				<?php foreach($ro['memory'] as $kitem=>$mitem): ?>
				<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
					<td>
						<p>
							<b class="space"><img src="/img/space.png"/></b>
							<a href="/kitty/#"><?php echo $kitem; ?>: <?php echo (($kitem=='used_memory_human')?($mitem):(number_format($mitem).'b')); ?></a>
						</p>
					</td>
				</tr>					
				<?php endforeach ?>
				<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
					<td>
						<p>
							<b class="space"><img src="/img/space.png"/></b>
							<a href="/kitty/#">fragmentation: <?php echo $ro['fragmentation']; ?></a>
						</p>
					</td>
				</tr>
				</tbody>
			</table>
			<br/>
		</div>
		<div class="fclear"></div>
	</div>
</div>
</body>
</html>
