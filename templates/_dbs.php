	<div id="global-navigation-shell">
		<div id="global-navigation">
			<ul id="menu">
				<li class="no-dash"><a href="/" class="current">DBs:</a></li>
<?php foreach($ro['dbs'] as $ditem): ?>
				<li>
					<a href="/server/db<?php echo $ditem['db']; ?>"<?php echo (($ditem['db']==$ro['server'])?' class="current"':''); ?>>DB#<?php echo $ditem['db']; ?> (<?php echo $ditem['keys']; ?>)</a>
				</li>
<?php endforeach ?>
			</ul>
			<div class="fclear"></div>
		</div>
	</div>
