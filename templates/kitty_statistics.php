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
			<li class="no-dash"><a href="/kitty/">Server</a></li>
			<li><a href="/kitty/info" class="current">Statistics</a></li>
			<li><a class="settings" href="/kitty/console">Console</a></li>
		</ul>
		<div class="fclear"></div>
	</div>
</div>

<div id="global-navigation-shell">
	<div id="global-navigation">
		<ul id="menu">
			<li class="no-dash"><a href="/kitty/">DBs:</a></li>
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
				<div style="display:inline;">Statistics</div>
			</h2>
		</div>
		<div class="arts">
			<table>
				<tbody>
				<?php $i=0; array_shift($ro); ?>
				<?php foreach($ro as $kitem=>$vitem): ?>
					<?php if ($kitem!='allocation_stats') { ?>
					<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a style="background-color:#89a118;" href="#"><?php echo $kitem; ?></a>&nbsp;
								<a style="background-color:#407fbf;" href="#"><?php echo $vitem; ?></a>
							</p>
						</td>
					</tr>
					<?php } else { ?>
					<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a style="background-color:#89a118;" href="#"><?php echo $kitem; ?></a>&nbsp;
								<?php foreach($vitem['values'] as $vitem2): ?>
									<b class="space2"><img src="/img/space.png"/></b>
									<a style="background-color:#407fbf;" href="#"><?php echo $vitem2; ?></a>
								<?php endforeach ?>
							</p>
						</td>
					</tr>
					<?php } ?>
				<?php endforeach ?>
				</tbody>
			</table>
			<br/>
		</div>
		<div class="fclear"></div>
	</div>
</div>
</body>
</html>
