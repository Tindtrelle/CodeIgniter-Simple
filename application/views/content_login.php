<div id="content">

<h1> Login</h1> 

	<?php
	echo form_open('site/login_validation');
	
	echo validation_errors();
	
	echo "<p>Username";
	echo form_input('username');
	echo "</p>";	
	
/*	echo form_open();
	echo "<p>Email";
	echo form_input('email');
	echo "</p>";	*/
	
	echo form_open();
	echo "<p>Password";
	echo form_password('password');
	echo "</p>";	
	
	echo form_submit("submit","Submit");
	echo form_close();
	?>
	<a href="<?php echo base_url();?>signup">Sign up </a>
</div>