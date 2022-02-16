<?php 
defined('BASEPATH') or exit('no dierct script access allowed');

class Customer_m extends MY_Model {

	protected $tbl_name = 'pos_customer';
    protected $primary_col = 'id';
    protected $order_by = 'created_on';

    public function __construct()
	{
		parent::__construct();   
	}



    public function getCustomerCount($phone){
        $this->db->select('id');
        $this->db->from('pos_customer');
        $this->db->where('phone', $phone);
        return $this->db->get()->num_rows();
    }


    public function getCustomer($phone){
        $this->db->from('pos_customer');
        $this->db->where('phone', $phone);
        return $this->db->get()->result_array();
    }


    // public function getValidUser($username, $password){
    //     $this->db->select('*');
    //     $this->db->from('users');
    //     $this->db->where('email', $username);
    //     $user = $this->db->get()->row();

    //     if(password_verify($password, $user->password)){
    //         return $user;
    //     }
    //     else{
    //         return false;
    //     }
    // }

    
    public function addCustomer($data){
        $this->db->insert('pos_customer', $data);
        return true;
    }


    public function updateCustomer($data,$phone){
     
        $this->db->where('phone', $phone);
        $this->db->update('pos_customer', $data);
        return true;
    }

  


//end class

}
