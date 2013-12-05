<div id="content">

<h1> Memmbers</h1> 

<?php 
	echo "<pre>";
	print_r ($this->session->all_userdata());
	echo "</pre>";
	
	$user = $this->session->userdata('username');
	$message = "Welcome $user ! ";
	echo heading($message,1);
	

?>
<a href="<?php echo base_url() ?>site/logout">LogOut</a>
</div>