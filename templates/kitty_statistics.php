<?php include('templates/_header.php'); ?>
<?php include('templates/_dbs.php'); ?>
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
<?php include('templates/_footer.php'); ?>
