<?php include('templates/_header.php'); ?>
<?php include('templates/_dbs.php'); ?>
	<div class="global-shell">
		<div class="widget-shell tabbing inner-shadow">
			<div class="widget-header">
				<h2>
					<div style="display:inline;">Console <?php echo $config['redis']['host'];?></div>
				</h2>
			</div>
			<div class="arts" id="console">
				<pre></pre>
				<form>
					<span class="inp">redis&rsaquo;&nbsp;<input type="text" value="" class="inp"/></span>
				</form>
			</div>
			<div class="fclear"></div>
		</div>
	</div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="/js/console.js"></script>
<?php include('templates/_footer.php'); ?>
