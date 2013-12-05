<?php 

	class Model_users extends CI_Model{
		
		function can_login(){
			$this->db->where("username", $this->input->post('username'));
			$this->db->where("password", md5($this->input->post('password')));
			
			$query = $this->db->get("ivan_users");
			
			if($query->num_rows() == 1){
				return true;
				
			}else{
				return false;}
		}
		
		function add_temp_user($key){
			$data = array(
						  'username' => $this->input->post('username'),
						  'email' => $this->input->post('email'),
						  'password' => md5($this->input->post('password')),
						  'key' => $key
						  );
			
			$query = $this->db->insert('ivan_users_temp', $data);
			if($query){
				return true;
			}else{
				return false;
			}
		}
		
		function is_key_valid($key){
			$this->db->where('key', $key);
			$query = $this->db->get('ivan_users_temp');
			
			if($query->num_rows()==1){
				return true;
			}else{
				return false;}
		}
		
		function add_user($key){
			$this->db->where('key', $key);
			
			$temp_user =  $this->db->get('ivan_users_temp');
			
			if($temp_user) {
				$row = $temp_user->row();
				$data = array(
							  'username' => $row->username,
							  'email' => $row->email,
							  'password' => $row->password
							  );
			
			
			$did_add_user = $this->db->insert('ivan_users',$data);
			}
			if($did_add_user){
				$this->db->where('key',$key);
				$this->db->delete('ivan_users_temp');
				return $data['username'];
			} else {
				return false;
			}
			
		}
		
	}