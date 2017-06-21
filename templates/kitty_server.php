<?php include('templates/_header.php'); ?>
<?php include('templates/_dbs.php'); ?>
	<div class="global-shell">
		<div class="widget-shell tabbing inner-shadow">
			<div class="widget-header">
				<h2>
					<div style="display:inline;">
						<a href="/server/db<?php echo $ro['server']; ?>/">DB#<?php echo $ro['server']; ?></a> Keys count: <?php echo $ro['keys_cnt']; ?>&nbsp;<?php echo $message; ?>
					</div>
				</h2>
			</div>
			<div class="arts">
				<table>
					<tbody>
					<?php $url='/server/db'.$ro['server'].'/'; ?>
					<?php $i=0; ?>
					<?php foreach($ro['keys'] as $kitem): ?>
						<tr class="<?php echo (($i%2)?'odd':'even'); $i++; ?>">
							<td>
								<p>
									<b class="space"><img src="/img/space.png"/></b>
									<a style="background-color:#407fbf;" href="<?php echo $url; ?>key/<?php echo urlencode($kitem['key']); ?>/"><?php echo $kitem['key']; ?></a>&nbsp;&nbsp;(type: <?php echo $kitem['type'].', '.(($kitem['type']=='string')?'lenght':'count').': '.$kitem['lenght']; ?>)
								</p>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
				<br/>
			</div>
			<div class="fclear"></div>
		</div>
	</div>
<?php include('templates/_footer.php'); ?>
