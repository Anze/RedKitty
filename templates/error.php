<?php include('templates/_header.php'); ?>
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
<?php include('templates/_footer.php'); ?>
