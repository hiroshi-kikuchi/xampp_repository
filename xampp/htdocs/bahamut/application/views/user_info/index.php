<?php foreach($user_info as $data): ?>
	<div class="main">
		<?php echo $data['id'] . "," 
		. $data['name'] . "," 
		. $data['coin'] . "," 
		. $data['update_time'] 
		. "<br />"; ?>
	</div>
<?php endforeach;
