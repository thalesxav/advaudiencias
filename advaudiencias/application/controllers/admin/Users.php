<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin/user_model', 'user_model');
			$this->load->library('datatable'); // loaded my custom serverside datatable library

			$this->rbac->check_module_access();
		}

		public function index(){
			//$data['view'] = 'admin/users/user_list';
			//$this->load->view('layout', $data);

			$data['users_detail'] = $this->user_model->get_all_users();
			$data['view'] = 'admin/users/user_list';
			$this->load->view('layout', $data);
		}
		
		public function datatable_json(){				   					   
			$records = $this->user_model->get_all_users();
			$data = array();

			$i=0;
			foreach ($records['data']  as $row) 
			{  
				$status = ($row['is_active'] == 1)? 'checked': '';
				$data[]= array(
					++$i,
					$row['username'],
					$row['email'],
					$row['mobile_no'],
					date_time($row['created_at']),	
					'<input class="tgl_checkbox tgl-ios" 
					data-id="'.$row['id'].'" 
					id="cb_'.$row['id'].'"
					type="checkbox"  
					'.$status.'><label for="cb_'.$row['id'].'"></label>',		

					'<a title="View" class="view btn btn-sm btn-info" href="'.base_url('admin/users/edit/'.$row['id']).'"> <i class="fa fa-eye"></i></a>
					<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('admin/users/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
					<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/users/delete/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-o"></i></a>'
				);
			}
			$records['data']=$data;
			echo json_encode($records);						   
		}

		//-----------------------------------------------------------
		function change_status()
		{   
			$this->user_model->change_status();
		}

		public function add(){
			
			$this->rbac->check_operation_access(); // check opration permission

			if($this->input->post('submit')){
				$this->form_validation->set_rules('username', 'Username', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['view'] = 'admin/users/user_add';
					$this->load->view('layout', $data);
				}
				else{
					//var_dump($this->input->post('estados[]'));exit;
					$data = array(
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						//'address' => $this->input->post('address'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'created_at' => date('Y-m-d : h:m:s'),
						'updated_at' => date('Y-m-d : h:m:s'),
						'acessos' => $this->RetornaAcessos($this->input->post('acessos[]')),
						'estados' => $this->RetornaEstados($this->input->post('estados[]')),
					);
					//var_dump($this->RetornaEstados($this->input->post('estados[]')));exit;
					$data = $this->security->xss_clean($data);
					//var_dump($data);exit;
					$result = $this->user_model->add_user($data);
					
					if($result){
						$this->session->set_flashdata('msg', 'Usuário cadastrado com sucesso!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else{
				$data['view'] = 'admin/users/user_add';
				$this->load->view('layout', $data);
			}
			
		}

		public function RetornaAcessos($acessos)
		{
			$retorno = "";
			foreach($acessos as $uf)
				$retorno .= $uf . ",";

			return  substr($retorno,0,-1);
			//exit;
		}

		public function RetornaEstados($estados)
		{
			$retorno = "";
			foreach($estados as $uf)
				$retorno .= $uf . ",";

			return  substr($retorno,0,-1);
		}

		public function edit($id = 0){

			$this->rbac->check_operation_access(); // check opration permission

			if($this->input->post('submit')){
				$this->form_validation->set_rules('username', 'Username', 'trim|required');
				//$this->form_validation->set_rules('firstname', 'Username', 'trim|required');
				//$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				//$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
				//$this->form_validation->set_rules('status', 'Status', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['user'] = $this->user_model->get_user_by_id($id);
					$data['view'] = 'admin/users/user_edit';
					$this->load->view('layout', $data);
				}
				else{
					$data = array(
						'username' => $this->input->post('username'),
						//'firstname' => $this->input->post('firstname'),
						//'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						//'mobile_no' => $this->input->post('mobile_no'),
						//'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						//'is_active' => $this->input->post('status'),
						'updated_at' => date('Y-m-d : h:m:s'),
						'acessos' => $this->RetornaAcessos($this->input->post('acessos[]')),
						'estados' => $this->RetornaEstados($this->input->post('estados[]')),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->user_model->edit_user($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Usuário atualizado com sucesso!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else{
				$data['user'] = $this->user_model->get_user_by_id($id);
				$data['view'] = 'admin/users/user_edit';
				$this->load->view('layout', $data);
			}
		}

		public function delete($id = 0)
		{
			$this->rbac->check_operation_access(); // check opration permission
			
			$this->db->delete('ci_users', array('id' => $id));
			$this->session->set_flashdata('msg', 'Usuário deletado com sucesso!');
			redirect(base_url('admin/users'));
		}

		public function change_pwd($id = 0)
		{
			if($this->input->post('submit'))
			{
				//var_dump($id);exit;
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('confirm_pwd', 'Password', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['user'] = $this->user_model->get_user_by_id($id);
					$data['view'] = 'admin/users/user_edit';
					$this->load->view('layout', $data);
				}
				else{
					//var_dump(password_hash($this->input->post('password'), PASSWORD_BCRYPT));exit;
					$data = array(
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->user_model->edit_user($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Senha atualizada com sucesso!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else
			{
				$this->rbac->check_operation_access(); // check opration permission
				$data['user'] = $this->user_model->get_user_by_id($id);
				$data['view'] = 'admin/users/change_pwd';
				$this->load->view('layout', $data);
			}
		}
	}


	?>