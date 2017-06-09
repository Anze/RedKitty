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
				<div style="display:inline;"><a href="/kitty/server/db<?php echo $ro['server']; ?>/">DB#<?php echo $ro['server']; ?></a> Key: <?php echo ($ro['key'])?($ro['key'].' (type: '.$ro['type'].', '.(($ro['type']=='string')?'lenght':'count').': '.$ro['lenght'].')'):''; ?></div>
			</h2>
		</div>
		<div class="arts">
			<table>
				<tbody>
				<?php $url='/kitty/server/db'.$ro['server'].'/'; ?>
				<?php if (count($keys)==1) { ?>
				<?php $i=0; ?>
				<?php foreach($ro['values'] as $vitem): ?>
					<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a style="background-color:#89a118;" href="#"><?php echo $vitem['key']; ?></a>&nbsp;
								<a style="background-color:#<?php echo ($ro['type']=='zset')?'e7a52a':'152a40'; ?>;" href="<?php echo ($ro['type']=='zset')?($url.'key/'.urlencode($vitem['value'])):'#'; ?>"><?php echo $vitem['value']; ?></a>
							</p>
						</td>
					</tr>
				<?php endforeach ?>
				<?php } else { ?>
				<?php foreach($ro['keys'] as $kitem): ?>
					<tr class="{cycle values='odd,even'}">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a style="background-color:#407fbf;" href="<?php echo $url; ?>key/<?php echo urlencode($kitem['key']); ?>/"><?php echo $kitem['key']; ?></a>&nbsp;&nbsp;<?php echo ' (type: '.$kitem['type'].', '.(($kitem['type']=='string')?'lenght':'count').': '.$kitem['lenght'].')'; ?>
							</p>
						</td>
					</tr>
				<?php endforeach ?>
				<?php } ?>
				</tbody>
			</table>
			<br/>
			<?php if ($pager['total']>1) { ?>
			<div class="paging_full_numbers">
				<a href="?page=1" class="first paginate_button<?php echo ($pager['current']==1)?' paginate_button_disabled':''; ?>">First page</a>
				<span>
					<?php echo pages($pager, $url.'key/'.$inkey.'/'); ?>
				</span>
				<a href="?page=<?php echo $pager['total']; ?>" class="last paginate_button<?php echo ($pager['current']==$pager['total'])?' paginate_button_disabled':''; ?>">Last page</a>
			</div>
			<?php } ?>
			<br/>
		</div>
		<div class="fclear"></div>
	</div>
</div>
</body>
</html>
