<div id="content">

<h1> Login</h1> 

	<?php
	echo form_open('site/signup_validation');
	
	echo validation_errors();
	
	echo "<p>Username";
	echo form_input('username', $this->input->post('username'));
	echo "</p>";	
	
	echo form_open();
	echo "<p>Email";
	echo form_input('email',$this->input->post('email'));
	echo "</p>";	
	
	echo form_open();
	echo "<p>Password";
	echo form_password('password');
	echo "</p>";	
	echo form_open();
	echo "<p>Confirm Password";
	echo form_password('cpassword');
	echo "</p>";
	
	echo form_submit("submit","Sign Up");
	echo form_close();
	?>

</div>