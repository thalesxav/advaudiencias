<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Advogado_model extends CI_Model{

	//-----------------------------------------------------
	function get_advogado_by_id($id)
	{
		$this->db->from('advogados');
		//$this->db->join('advogado_comarcas','advogado_comarcas.codigo_advogado IN (select X.admin_role_id from advogado_comarcas X where X.admin_id = ci_admin.admin_id)');
		$this->db->join('advogado_comarca', 'advogados.codigo = advogado_comarca.codigo_advogado ', 'Inner');
		$this->db->join('comarcas', 'comarcas.codigo = advogado_comarca.codigo_comarca ', 'Inner');
		
		$this->db->where('advogados.codigo',$id);
		$query=$this->db->get();
		$retorno = array();
		$retorno['comarcas_ids']=array();
		$count=0;

		foreach($query->result_array() as $x => $y)
		{
			foreach($y as $k => $v)
			{
				if($k == 'codigo_comarca')
				{
					$retorno['comarcas_ids'][$count] = $v;
					$count++;
				}
				$retorno[$k] = $v;
			}
		}
		
		//var_dump($retorno);exit;
		return $retorno;
		//echo $this->db->last_query();exit;
		//var_dump($query->result_array());exit;
		//return $query->row_array();
	}

	//-----------------------------------------------------
	function get_estados()
	{
		//$this->db->select('admin_role_id');
		$this->db->from('estados');
		$query=$this->db->get();
		return $query->result_array();
	}

	//-----------------------------------------------------
	function get_all()
	{
		$this->db->from('advogados');
		/*$this->db->join('ci_admin_roles','ci_admin_roles.admin_role_id=ci_admin.admin_role_id');
		
		if($this->session->userdata('filter_type')!='')
			$this->db->where('ci_admin.admin_role_id',$this->session->userdata('filter_type'));

		if($this->session->userdata('filter_status')!='')
			$this->db->where('ci_admin.is_active',$this->session->userdata('filter_status'));

		$filterData = $this->session->userdata('filter_keyword');
		$where = "(
			ci_admin_roles.admin_role_title like '%$filterData%' OR
			ci_admin.firstname like '%$filterData%' OR
			ci_admin.lastname like '%$filterData%' OR
			ci_admin.email like '%$filterData%' OR
			ci_admin.mobile_no like '%$filterData%' OR
			ci_admin.username like '%$filterData%'
		)";
		$this->db->where($where);

		$this->db->order_by('ci_admin.admin_id','desc');*/
			//$this->db->limit($limit, $offset);
		$query = $this->db->get();
		$module = array();
		if ($query->num_rows() > 0) 
		{
			$module = $query->result_array();
		}
		return $module;
	}

		//-----------------------------------------------------
	public function add_advogado($data){
		$this->db->insert('advogados', $data);
		
		return true;
	}

	public function add_advogado_comarcas($data){

		$x['codigo_advogado'] = $data['codigo_advogado'];

		foreach($data['comarcas'] as $key => $value)
		{
			$x['codigo_comarca'] = $value;
			$this->db->insert('advogado_comarca', $x);
		}
		
		return true;
	}

	public function get_last_id(){
		$this->db->from('advogados');
		$this->db->order_by('codigo	','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		//var_dump($query);
		if ($query->num_rows() == 0)
			return 1;

		//var_dump($query->result_array()[0]['codigo']);
		//var_dump($query->result_array());exit;
		return $query->result_array()[0]['codigo'] + 1;
	}

	//---------------------------------------------------
	// Edit Admin Record
	public function edit($data, $id){
		$this->db->where('codigo', $id);
		$this->db->update('advogados', $data);
		
		//echo $this->db->last_query();exit;
		return true;
	}

		//-----------------------------------------------------
	function delete($id)
	{		
		$this->db->where('codigo_advogado',$id);
		$this->db->delete('advogado_comarca');

		$this->db->where('codigo',$id);
		$this->db->delete('advogados');
	} 

}

?>