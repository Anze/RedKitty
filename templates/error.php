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
			<li class="no-dash"><a href="/kitty/">DBs:</a></li>
		</ul>
		<div class="fclear"></div>
	</div>
</div>

<div class="global-shell">
	<div class="widget-shell tabbing inner-shadow">
		<div class="widget-header">
			<h2>
				<div style="display:inline;">Error</div>
			</h2>
		</div>
		<div style="margin-left:24px; margin-top:24px; margin-bottom:24px;">
			<p><?php echo $e->getMessage(); ?></p>
			<br/>
			<?php echo $e->getFile().':'.$e->getLine(); ?>
			<br/>
			<pre><?php print_r($e->getTrace(), 1); ?></pre>
		</div>
	</div>
</div>
</body>
</html>