<?php
	class User_model extends CI_Model{

		public function add_user($data){
			//var_dump($data);exit;

			$array_copy = $data;
			//unset($data['acessos']);
			//unset($data['estados']);

			$this->db->insert('ci_users', $data);
			/*$insertId = $this->db->insert_id();

			$array_estados = array();
			$estados = explode(',', $array_copy['estados']);
			
			foreach($estados as $uf)
			{
				$array_estados['id_usuario'] = $insertId;
				$array_estados['codigo'] = $uf;
				$this->db->insert('usuarios_estados', $array_estados);
			}
			
			$array_acessos = array();
			$acessos = explode(',', $array_copy['acessos']);
			
			foreach($acessos as $a)
			{
				$array_acessos['id_usuario'] = $insertId;
				$array_acessos['acesso'] = $a;
				$this->db->insert('usuarios_acessos', $array_acessos);
			}*/

			return true;
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_users(){
			/*$wh =array();
			$SQL ='SELECT * FROM ci_users';
			$wh[] = " is_admin = 0";
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}*/
			$this->db->select('
					*
					'
	    	);
	    	$this->db->from('ci_users');
			//$this->db->join('usuarios_acessos', 'ci_users.id = usuarios_acessos.id_usuario ');
			$this->db->where('is_admin', '0');
			$query = $this->db->get();
			return $query->result_array();
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_user_by_id($id){
			$query = $this->db->get_where('ci_users', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_user($data, $id){
			//var_dump($data);exit;
			$this->db->where('id', $id);
			$this->db->update('ci_users', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_users');
		} 

	}

?>