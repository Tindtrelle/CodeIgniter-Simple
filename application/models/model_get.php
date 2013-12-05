<?php
	class Model_get extends CI_Model{
		function get_data($page){
			$query = $this->db->get_where("ivan_posts", array("page" =>$page));
			
			return $query->result();
		}
	}