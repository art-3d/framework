<div class="container">
	<form class="form-update" role="form" method="post" action="<?php echo $action ?>">
		<p>Role: <?php echo $profile->role ?></p>
		<p>Email: <?php echo $profile->email ?></p>
		<div class="form-group">
			<label for="password">Old password:</label>
			<input type="password" class="form-control" id="password" required name="password" />
		</div>
		<div class="form-group">
			<label for="pass_new">New password:</label>
			<input type="password" class="form-control" id="pass_new" required name="password_new" />
		</div>
		<div class="form-group">
			<label for="pass_new_copy">Repeat new password:</label>
			<input type="password" class="form-control" id="pass_new_copy" required name="password_new_copy"/>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Change</button>
	</form>
</div>
