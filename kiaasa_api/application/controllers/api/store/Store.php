<?php

class Store extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}



	public function getStore()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		
				$stores = $this->store_m->getStores();
				if (!empty($stores)) {
                   

						$newdata = array( 
							
							'states' => $stores
						);
                        $response = ['status' => 200, 'message' => 'success', 'description' => 'There is states list.', 'data'=>$newdata];
					
				} else {
				


						
						$response = ['status' => 200, 'message' => 'error', 'description' => 'There is some error'];
					}
				
			
		} else {
			$response = ['status' => 200, 'message' => 'error', 'description' => 'Bad request'];
		}
		echo json_encode($response);
		exit();
	}

	




	public function addStore()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$this->form_validation->set_rules('store_name', 'store_name', 'required|alpha_numeric');
            // $this->form_validation->set_rules('region_id', 'region_id', 'required|numeric');
            // $this->form_validation->set_rules('address_line1', 'address_line1', 'required|alpha_numeric');
            // $this->form_validation->set_rules('address_line2', 'address_line2', 'required|alpha_numeric');
            // $this->form_validation->set_rules('city_name', 'city_name', 'required|alpha_numeric');
            // $this->form_validation->set_rules('postal_code', 'postal_code', 'required|numeric');
            // $this->form_validation->set_rules('state_id', 'state_id', 'required|numeric');
            // $this->form_validation->set_rules('phone_no', 'phone_no', 'required|numeric');
            // $this->form_validation->set_rules('gst_no', 'gst_no', 'required|alpha_numeric');
            // $this->form_validation->set_rules('gst_name', 'gst_name', 'required|alpha_numeric');
            // $this->form_validation->set_rules('store_code', 'store_code', 'required|numeric');
            // $this->form_validation->set_rules('store_type', 'store_type', 'required|numeric');
           
            // $this->form_validation->set_rules('gst_type', 'GST Type');
            
			
			
			
			if ($this->form_validation->run() == FALSE) {
				var_dump($this->input->post()); 
				$response = ['status' => 200, 'message' => 'error', 'description' => 'Enter correct detail.'];
			} else {
				$storeCount = $this->store_m->getStoreCount($this->input->post('store_name'));
				if ($storeCount > 0) {
					$response = ['status' => 200, 'message' => 'error', 'description' => 'You are already registered.'];
				} else {
				
					$data['store_name'] = $this->input->post('store_name');
                    // $data['region_id'] = $this->input->post('region_id');
                    // $data['address_line1'] = $this->input->post('address_line1');
                    // $data['address_line2'] = $this->input->post('address_line2');
                    // $data['city_name'] = $this->input->post('city_name');
                    // $data['postal_code'] = $this->input->post('postal_code');
                    // $data['state_id'] = $this->input->post('state_id');
                    // $data['phone_no'] = $this->input->post('phone_no');
                    // $data['gst_no'] = $this->input->post('gst_no');
                    // $data['gst_name'] = $this->input->post('gst_name');
                    // $data['store_code'] = $this->input->post('store_code');
                    // $data['store_type'] = $this->input->post('store_type');
                   
                
                    // $data['created_at'] =  time();
                    // $data['updated_at'] = time();

                    
					// $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
					$insert = $this->store_m->addStore($data);
					if ($insert == true) {

						$user = array(
							'store_id' => $this->db->insert_id(),
                        );

						// $this->db->insert('user_profile', $user);
						// $this->db->insert('user_profile_files', $user);
						// $this->db->insert('user_salary', $user);

						$newdata = array( 
							'sid'=> $this->db->insert_id(),
							'email'  => $data['email'],
							'phone'  => null,
							'name'  => null,
							'role_id'  => 2,
							'user_profile' => [],
						);


						$response = ['status' => 200, 'message' => 'success', 'description' => 'Store is successfully registered.', 'data'=>$newdata];
					} else {
						$response = ['status' => 200, 'message' => 'error', 'description' => 'There is some error'];
					}
				}
			}
		} else {
			$response = ['status' => 200, 'message' => 'error', 'description' => 'Bad request'];
		}
		echo json_encode($response);
		exit();
	}








	//CLASS ENDS
}


