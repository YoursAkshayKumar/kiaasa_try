<?php

class States extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}




	public function getState()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		
				$states = $this->state_m->getStates();
				if (!empty($states)) {

						$newdata = array( 
							
							'states' => $states
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

	






	//CLASS ENDS
}
