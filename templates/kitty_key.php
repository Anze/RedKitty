<?php include('templates/_header.php'); ?>
<?php include('templates/_dbs.php'); ?>
	<div class="global-shell">
		<div class="widget-shell tabbing inner-shadow">
			<div class="widget-header">
				<h2>
					<div style="display:inline;">
						<a href="/server/db<?php echo $ro['server']; ?>/">DB#<?php echo $ro['server']; ?></a> Key: <?php echo ($ro['key'])?($ro['key'].' (type: '.$ro['type'].', '.(($ro['type']=='string')?'lenght':'count').': '.$ro['lenght'].')'):''; ?>
					</div>
				</h2>
			</div>
			<div class="arts">
				<table>
					<tbody>
					<?php $url='/server/db'.$ro['server'].'/'; ?>
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
						<?php echo Helper::pages($pager, $url.'key/'.$inkey.'/'); ?>
					</span>
					<a href="?page=<?php echo $pager['total']; ?>" class="last paginate_button<?php echo ($pager['current']==$pager['total'])?' paginate_button_disabled':''; ?>">Last page</a>
				</div>
				<?php } ?>
				<br/>
			</div>
			<div class="fclear"></div>
		</div>
	</div>
<?php include('templates/_footer.php'); ?>
