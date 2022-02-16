<?php

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function apiToken(){

	}

	public function userLogin()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			if ($this->form_validation->run() == FALSE) {
				$response = ['status' => 200, 'message' => 'error', 'description' => 'Enter correct detail.'];
			} else {
				$userCount = $this->auth_m->getUserCount($this->input->post('username'));
				if ($userCount > 0) {
					$data = $this->auth_m->getValidUser($this->input->post('username'), $this->input->post('password'));
					if ($data == false) {
						$response = ['status' => 200, 'message' => 'error', 'description' => 'Password is invalid.'];
					} else {
						$this->db->select('*');
						$this->db->from('user_profile');
						$this->db->where('user_id', $data->id);
						// $this->db->order_by('is_default', 'desc');
						// var_dump($data->id); exit;
						$user_profile = $this->db->get()->result_array();
						$newdata = array( 
							'uid'=> $data->id,
							'email'  => $data->email,
							'name'  => $data->name,
							'user_type'  => $data->user_type,
							'user_profile' => $user_profile,
						);
						$response = ['status' => 200, 'message' => 'success', 'description' => 'You are login successfully', 'data' => $newdata];
					}
				} else {
					$response = ['status' => 200, 'message' => 'error', 'description' => 'You are not registered.'];
				}
			}
		} else {
			$response = ['status' => 200, 'message' => 'error', 'description' => 'Bad request'];
		}
		echo json_encode($response);
		exit();
	}


	public function userRegister()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			if ($this->form_validation->run() == FALSE) {
				$response = ['status' => 200, 'message' => 'error', 'description' => 'Enter correct detail.'];
			} else {
				$userCount = $this->auth_m->getUserCount($this->input->post('username'));
				if ($userCount > 0) {
					$response = ['status' => 200, 'message' => 'error', 'description' => 'You are already registered.'];
				} else {
					$data['name'] = $this->input->post('name');
					$data['email'] = $this->input->post('username');
					$data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
					$insert = $this->auth_m->registerUser($data);
					if ($insert == true) {

						$user = array(
							'user_id' => $this->db->insert_id(),
                        );

						$this->db->insert('user_profile', $user);
						$this->db->insert('user_profile_files', $user);
						$this->db->insert('user_salary', $user);

						$newdata = array( 
							'uid'=> $this->db->insert_id(),
							'email'  => $data['email'],
							'phone'  => null,
							'name'  => null,
							'role_id'  => 2,
							'user_profile' => [],
						);


						$response = ['status' => 200, 'message' => 'success', 'description' => 'You are successfully registered.', 'data'=>$newdata];
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

	public function update_user_profile(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
			$this->form_validation->set_rules('email', 'Email Id', 'trim|required|alpha_numeric_spaces');
			if ($this->form_validation->run() == FALSE) {
				$response = ['status' => 200, 'message' => 'error', 'description' => 'Enter correct detail.'];
			}
			else{
				$this->db->select('*');
				$this->db->from('users');
				$this->db->where('user_id', $this->input->post('user_id'));
				$user = $this->db->get()->row();

				$data = array(
					'name'=>$this->input->post('name'),
					'email'=>$this->input->post('email')
				);

				$this->db->where('user_id',$this->input->post('user_id'));
				$isDataSaved = $this->db->update('users',$data);
				if($isDataSaved){
					$this->db->select('*');
					$this->db->from('user_profile');
					$this->db->where('user_id', $this->input->post('user_id'));
					$this->db->order_by('is_default', 'desc');
					$user_profile = $this->db->get()->result_array();

					$this->db->select('*');
					$this->db->from('users');
					$this->db->where('user_id', $this->input->post('user_id'));
					$user = $this->db->get()->row();

					$newdata = array( 
						'uid'=> $user->user_id,
						'email'  => $user->email,
						'phone'  => $user->contact,
						'name'  => $user->name,
						'role_id'  => $user->role_id,
						'user_profile' => $user_profile,
					);
					$response = ['status' => 200, 'message' => 'success', 'description' => 'Profile updated successfully.', 'data'=>$newdata];
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
