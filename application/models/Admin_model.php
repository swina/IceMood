<?php

class Admin_Model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	
	function listTblAdmin(){	
		$sql='SELECT admin_id
					,admin_name
					,admin_email
					,admin_password
					,admin_role
					
					FROM
						tbl_admin WHERE 1=1 ';
			                  
			
			 	if($this->isPropertySet('admin_id'))
					$sql.=" AND admin_id='".$this->getProperty('admin_id')."'";
				
			 	if($this->isPropertySet('admin_name'))
					$sql.=" AND admin_name='".$this->getProperty('admin_name')."'";
				
			 	if($this->isPropertySet('admin_email'))
					$sql.=" AND admin_email='".$this->getProperty('admin_email')."'";
				
			 	if($this->isPropertySet('admin_password'))
					$sql.=" AND admin_password='".$this->getProperty('admin_password')."'";
				
			 	if($this->isPropertySet('admin_role'))
					$sql.=" AND admin_role='".$this->getProperty('admin_role')."'";
				
echo $sql;
			return $this->dbFetchArray($sql);
			

	}
	
	function fnTblAdmin($mode="I"){	
		$data['admin_name']=$this->getProperty('admin_name');
		$data['admin_email']=$this->getProperty('admin_email');
		$data['admin_password']=$this->getProperty('admin_password');
		$data['admin_role']=$this->getProperty('admin_role');
	
		if($mode=="I"){
    			return $this->db->insert('tbl_admin',$data);
    	       
   		}
	    	else if ($mode=="U"){            
	    		$where_arr['admin_id']=$this->getProperty('admin_id');
	        	$this->db->where($where_arr);
			return $this->db->update('tbl_admin',$data);	    
	 	}
	    	else if($mode=="D"){
			$where_arr['admin_id']=$this->getProperty('admin_id');
	        	$this->db->where($where_arr);
			return $this->db->delete('tbl_admin');	    	    
	    	}
			    		
	}
	
	 public function validate(){
        // grab user input
        $username = $this->input->post('user_email');
        $password = $this->input->post('user_pass');
		if ( $username == trim($this->config->item ( 'admin')) ){
			if ( $password == trim($this->config->item ( 'admin_pw')) ) {
				$data = array(
                    'adminid' => 1,
                    'aname' => $username,
                    'aemail' => $this->config->item ( 'admin_email' ),                   
                    'validated' => true
                    );
				$this->session->set_userdata($data);
                return "1";
			} 
		} 
		
    }
	
}