<?php include('templates/_header.php'); ?>
<?php include('templates/_dbs.php'); ?>
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
								<a style="background-color:#407fbf;" href="/server/db<?php echo $ditem['db']; ?>/">DB#<?php echo $ditem['db']; ?></a>&nbsp;&nbsp;
								<a style="background-color:#89a118;" href="/server/db<?php echo $ditem['db']; ?>/">keys: <?php echo $ditem['keys']; ?></a>&nbsp;&nbsp;
								<a style="background-color:#e7a52a;" href="/server/db<?php echo $ditem['db']; ?>/">expires: <?php echo $ditem['expires']; ?></a>
							</p>
						</td>
					</tr>
					<?php endforeach ?>
					<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a href="#">version: <?php echo $ro['version']; ?></a>
							</p>
						</td>
					</tr>
					<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a href="#">last save: <?php echo date("Y-m-d H:i:s", $ro['last_save']); ?></a>
							</p>
						</td>
					</tr>
					<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a href="#">uptime: <?php echo $ro['uptime']; echo Helper::plural($ro['uptime'], 'day', 'days', 'days'); ?></a>
							</p>
						</td>
					</tr>
					<?php foreach($ro['memory'] as $kitem=>$mitem): ?>
					<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a href="#"><?php echo $kitem; ?>: <?php echo (($kitem=='used_memory_human')?($mitem):(number_format($mitem).'b')); ?></a>
							</p>
						</td>
					</tr>
					<?php endforeach ?>
					<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
						<td>
							<p>
								<b class="space"><img src="/img/space.png"/></b>
								<a href="#">fragmentation: <?php echo $ro['fragmentation']; ?></a>
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
<?php include('templates/_footer.php'); ?>
