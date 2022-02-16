<?php

class Customer extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}



	public function addCustomer()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[10]');
			$this->form_validation->set_rules('salutation', 'salutation');
			$this->form_validation->set_rules('customer_name', 'customer_name');
			$this->form_validation->set_rules('email', 'email', 'trim|valid_email');
			$this->form_validation->set_rules('dob', 'dob'); 
			$this->form_validation->set_rules('wedding_date', 'wedding_date');
			$this->form_validation->set_rules('postal_code', 'postal_code', 'trim|min_length[6]');
			
			if ($this->form_validation->run() == FALSE) {
				$response = ['status' => 200, 'message' => 'error', 'description' => 'Enter correct detail.'];
				var_dump($this->input->post()); 
			} else {
				$customerCount = $this->customer_m->getCustomerCount($this->input->post('phone'));
				if ($customerCount > 0) {
					$response = ['status' => 200, 'message' => 'error', 'description' => 'Customer is already registered.'];
				} else {
					
					$data['phone'] = $this->input->post('phone');
					$data['salutation'] = $this->input->post('salutation');
					$data['customer_name'] = $this->input->post('customer_name');
					$data['email'] = $this->input->post('email');
					$data['dob'] = $this->input->post('dob');
					$data['wedding_date'] = $this->input->post('wedding_date');
					$data['postal_code'] = $this->input->post('postal_code');
					$data['created_at'] = date("Y-m-d h-i-s");

					
					$insert = $this->customer_m->addCustomer($data);
					if ($insert == true) {

						// $user = array(
						// 	'customer_id' => $this->db->insert_id(),
                        // );

						// $this->db->insert('user_profile', $user);
						// $this->db->insert('user_profile_files', $user);
						// $this->db->insert('user_salary', $user);

						$newdata = array( 
							'cid'=> $this->db->insert_id(),
							'email'  => $data['email'],
							'phone'  => $data['phone'],
							'name'  => $data['customer_name'],
							
						);


						$response = ['status' => 200, 'message' => 'success', 'description' => 'Customer is successfully added.', 'data'=>$newdata];
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




    public function getCustomer()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[10]');
			
			// $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			if ($this->form_validation->run() == FALSE) {
				$response = ['status' => 200, 'message' => 'error', 'description' => 'Enter correct detail.'];
			} else {
				$customerCount = $this->customer_m->getCustomerCount($this->input->post('phone'));
				if ($customerCount > 0) {
					// $response = ['status' => 200, 'message' => 'error', 'description' => 'You are already registered.'];
                    $customer = $this->customer_m->getCustomer($this->input->post('phone'));

                    $newdata = array( 
                        'customer'=> $customer
                        
                    );
                    	$response = ['status' => 200, 'message' => 'success', 'description' => 'You are successfully registered.', 'data'=>$newdata];

				} else {
					
                    $response = ['status' => 200, 'message' => 'error', 'description' => 'There is some error'];
                }
					

					
					}

		} else {
			$response = ['status' => 200, 'message' => 'error', 'description' => 'Bad request'];
		}
		echo json_encode($response);
		exit();
	}






	public function update_Customer(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[10]');
			$this->form_validation->set_rules('salutation', 'salutation');
			$this->form_validation->set_rules('customer_name', 'customer_name');
			$this->form_validation->set_rules('email', 'email', 'trim|valid_email');
			$this->form_validation->set_rules('dob', 'dob'); 
			$this->form_validation->set_rules('wedding_date', 'wedding_date');
			$this->form_validation->set_rules('postal_code', 'postal_code', 'trim|min_length[6]');
			
			if ($this->form_validation->run() == FALSE) {
				$response = ['status' => 200, 'message' => 'error', 'description' => 'Enter correct detail.'];
			}
			else{
				$this->db->select('*');
				$this->db->from('pos_customer');
				$this->db->where('phone', $this->input->post('phone'));
				$user = $this->db->get()->row();

				$data = array(
					'salutation'=>$this->input->post('salutation'),
					'customer_name'=>$this->input->post('customer_name'),
					'email'=>$this->input->post('email'),
					'dob'=>$this->input->post('dob'),
					'wedding_date'=>$this->input->post('wedding_date'),
					'postal_code'=>$this->input->post('postal_code'),
					'updated_at'=> date("Y-m-d h-i-s")
				);

				$this->db->where('phone',$this->input->post('phone'));
				$isDataSaved = $this->db->update('pos_customer',$data);
				if($isDataSaved){


					$this->db->select('*');
					$this->db->from('pos_customer');
					$this->db->where('phone', $this->input->post('phone'));
					$customer = $this->db->get()->row();

					// $newdata = array( 
					// 	'cid'=> $user->user_id,
					// 	'email'  => $user->email,
					// 	'phone'  => $user->contact,
					// 	'name'  => $user->name,
					// 	'role_id'  => $user->role_id,
					// 	'user_profile' => $user_profile,
					// );
					$response = ['status' => 200, 'message' => 'success', 'description' => 'Customer updated successfully.', 'data'=>$customer];
				}
				else{
					$response = ['status' => 200, 'message' => 'error', 'description' => 'Something went wrong'];
				}
			}	
		}
		else{
			$response = ['status' => 200, 'message' => 'error', 'description' => 'Bad request.'];
		}
		echo json_encode($response);
	}

	






	//CLASS ENDS
}
