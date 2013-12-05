<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
	/*Views loading*/
	public function index(){
		$this->home();
	}
	public function home(){
		$this->load->model("model_get");
		$data["results"]= $this->model_get->get_data('home');
		
		$this->load->view("view_header");
		$this->load->view("view_navigation");
		$this->load->view("content_home",$data);
		$this->load->view("view_footer");
	}
	public function about(){
		$this->load->model("model_get");
		$data["results"]= $this->model_get->get_data('about');
		
		$this->load->view("view_header");
		$this->load->view("view_navigation");
		$this->load->view("content_about",$data);
		$this->load->view("view_footer");
	}
	public function contact(){
		
		$this->load->view("view_header");
		$this->load->view("view_navigation");
		$this->load->view("content_contact");
		$this->load->view("view_footer");
	}
	/*Login Form*/
	public function login(){
		
		$this->load->view("view_header");
		$this->load->view("view_navigation");
		$this->load->view("content_login");
		$this->load->view("view_footer");
	}
	public function memmbers(){
		if($this->session->userdata('logged_in')){
			
			$this->load->view("view_header");
			$this->load->view("view_navigation");
			$this->load->view("content_memmbers");
			$this->load->view("view_footer"); }
			else {
				redirect("site/restricted");
			}
	}
	public function restricted(){
		$this->load->view("view_header");
			$this->load->view("view_navigation");
			$this->load->view("content_restricted");
			$this->load->view("view_footer");
	}
	public function login_validation(){
		
		$this->load->library("form_validation");
		$this->form_validation->set_rules("username", "Username", "required|xss_clean|trim|callback_validate_credentials");
		$this->form_validation->set_rules("password", "Password", "required|xss_clean");
		
		if($this->form_validation->run()){
			$data = array(
                   'username'  => $this->input->post('username'),
                   'logged_in' => TRUE
               );

			$this->session->set_userdata($data);
			
			redirect("site/memmbers");
			}else {
				$this->login();
			}
	}
	public function validate_credentials(){
		
		$this->load->model("model_users");
		if($this->model_users->can_login()){
			return true;
		}
		else{
			$this->form_validation->set_message("validate_credentials","Incorrect Username/Password.");
			return false;
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		$this->home();
	}
	/*Sing up form*/
	
	public function signup(){
		
		$this->load->view("view_header");
		$this->load->view("view_navigation");
		$this->load->view("content_singup");
		$this->load->view("view_footer");
	}
	public function signup_validation(){
		
		$this->load->library("form_validation");
		$this->load->model("model_users");
		
		$this->form_validation->set_rules("username", "Username", "required|xss_clean|trim|is_unique[ivan_users.username]|trim");
		$this->form_validation->set_rules("email", "Email", "required|trim|xss_clean|valid_email|trim|is_unique[ivan_users.email]");
		$this->form_validation->set_rules("password", "Password", "required|xss_clean|trim");
		$this->form_validation->set_rules("cpassword", "Confirm Password", "required|trim|xss_clean|matches[password]");
		
		if($this->form_validation->run()){
			$key = md5(uniqid());
			
			$this->load->library("email", array('mailtype'=>'html'));
			$this->email->from('maloparac@hotmail.com', 'Ivan Maloparac');
			$this->email->to($this->input->post('email') );
			$this->email->subject("Confirm your registration");
			
			$message = "<p>Thank you for signing up</p>";
			$message .= "<p><a href='".base_url()."site/register_user/$key' > Click here </a> to confirm registration!<p>";
			$this->email->message($message);
					if($this->model_users->add_temp_user($key)){
						$this->email->send(); 
						echo "Confirmation e-mail sent";
						}
					else {
						echo "Problem adding user to database!" ;}
					
			
		}else {
				
				$this->signup();
			}
	}
	public function register_user($key){
			$this->load->model("model_users");
			
			if($this->model_users->is_key_valid($key)){
				if($newusername = $this->model_users->add_user($key)){
					$data = array(
                   'username'  => $newusername,
                   'logged_in' => TRUE
               );

			$this->session->set_userdata($data);
			
			redirect("site/memmbers");
				} else {
					echo "failed to confirm user, please try again";
				}
			}else{
				echo "invalid key";
			}
		
		
	}
	/*Email form*/
	public function send_email(){
		$this->load->library("form_validation");
		
		$this->form_validation->set_rules("fullName", "Full Name", "required|xss_clean|alpha");
		$this->form_validation->set_rules("email", "Email Address", "required|xss_clean|valid_email");
		$this->form_validation->set_rules("message", "Message", "required|xss_clean");
				if($this->form_validation->run() == FALSE){
			
			$this->load->view("view_header");
			$this->load->view("view_navigation");
			$this->load->view("content_contact");
			$this->load->view("view_footer");
		} 		else {
			$data["message"] = "Forma poslata!</br>";
			
			$this->load->library("email");
			
			$this->email->from(set_value("email"), set_value("fullName"));
			$this->email->to("maloparac@hotmail.com");
			$this->email->subject("E mail sa sajta");
			$this->email->message(set_value("message"));
			
			$this->email->send();
			
			//echo $this->email->print_debugger();
			
			$this->load->view("view_header");
			$this->load->view("view_navigation");
			$this->load->view("content_contact",$data);
			$this->load->view("view_footer");
		}
	}
}
