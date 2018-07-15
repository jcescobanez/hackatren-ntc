<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Android_api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('users');

                

		// $user = $this->users_model->getfirstlove(1);


		// var_dump($user);
	}
	

	public function app_register()
	{
		//$user_name = $this->input->post('user_name');
		$password = $this->input->post('password');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$middlename = $this->input->post('middlename');
		$address = $this->input->post('address');
		$contactnumber = $this->input->post('contactnumber');
		$email = $this->input->post('email');
		
		





		

		if($email == NULL | $password == NULL)
   		{
   			$return_data["status"] = "FAILED";
   			$return_data["message"] = "Fill up all fields";

			echo json_encode($return_data);
   			
   		}
   		else
   		{
   			$data = $this->users->register_user(
   			$password,
			$firstname,
			$lastname,
			$middlename,
			$address,
			$contactnumber,
			$email
		

   				);


   			if($data == "failed")
	   		{
	   			$return_data["status"] = "FAILED";
	   			$return_data["message"] = "Email already exsists";

				echo json_encode($return_data);
	   			
   			}
   			else
   			{
   				$return_data["status"] = $data; 
    			$return_data["message"] = "Successfully registered."; 

    			echo json_encode($return_data);
   			}

    		
   		}

		
	}

	public function app_login()
	{
		$student_no = $this->input->post('username');
		$password = $this->input->post('password');
		$token = $this->input->post('token');



		if($student_no == NULL || $password == NULL)
   		{
   			$return_data["status"] = "FAILED";
   			$return_data["message"] = "Fill up all fields";

			echo json_encode($return_data);
   			
   		}
   		else
   		{
   			$data = $this->users->get_login_credentials($student_no, $password);


   			if($data == NULL)
	   		{
	   			$return_data["status"] = "FAILED";
	   			$return_data["message"] = "No user found. Please try again.";

				echo json_encode($return_data);
	   			
   			}
   			else
   			{
			$data1 = $this->users->update_token($token, $student_no);
   				
   			$return_data["status"] = "SUCCESS"; 
    			$return_data["message"] = "User successfully logged in."; 
    			$return_data["data"] = $data; 

    			echo json_encode($return_data);
   			}

    		
   		}

		
	}
	
	public function get_fruit_price()
	{
		$fruit = $this->input->post('fruit');
		

		if ($fruit == null)
		{
			$return_data["status"] = "FAILED";
			$return_data['message'] = "Please fill up all fields.";
			echo json_encode($return_data);
		}
		else
		{
			$user = $this->users->get_fruit_price($fruit);
			if ($user == "FAILED")
			{
				$return_data["status"] = "FAILED";
				$return_data['message'] = "No fruit price available.";
				echo json_encode($return_data);
			}
			else
			{
				$return_data["status"] = "SUCCESS";
				$return_data['data'] = $user;
				echo json_encode($return_data);
			}
		}
	}
	
	public function get_fruits()
	{
		
		

		$user = $this->users->get_fruits();
			if ($user == "FAILED")
			{
				$return_data["status"] = "FAILED";
				$return_data['message'] = "No fruits available.";
				echo json_encode($return_data);
			}
			else
			{
				$return_data["status"] = "SUCCESS";
				$return_data['data'] = $user;
				echo json_encode($return_data);
			}
		
	}
	
	public function get_story()
	{
		$command = $this->input->post('command');
		

		if ($command == null)
		{
			$return_data["status"] = "FAILED";
			$return_data['message'] = "Please fill up all fields.";
			echo json_encode($return_data);
		}
		else
		{
			$user = $this->users->get_story($command);
			if ($user == "FAILED")
			{
				$return_data["status"] = "FAILED";
				$return_data['message'] = "No story available.";
				echo json_encode($return_data);
			}
			else
			{
				$return_data["status"] = "SUCCESS";
				$return_data['data'] = $user;
				echo json_encode($return_data);
			}
		}
	}

public function list_product() 
	{
		$data = $this->users->get_product();

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No product found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	public function list_story() 
	{
		$data = $this->users->get_stories();

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No product found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	public function query_product() 
	{

		$query = $this->input->post('query');
		$cat_id = $this->input->post('cat_id');

		$data = $this->users->get_query_product($query, $cat_id);

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No product found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	public function query_product_no_cat() 
	{

		$query = $this->input->post('query');
		

		$data = $this->users->get_query_product_no_cat($query);

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No product found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	
	public function delete_cart() 
	{

		$user_id = $this->input->post('user_id');
		$product_id = $this->input->post('id');

		$data = $this->users->remove_cart($user_id, $product_id);

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No product found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";

			echo json_encode($return_data);
		}
	}
	public function list_categories() 
	{
		$data = $this->users->get_categories();

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No categories found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	public function list_stations() 
	{
		$data = $this->users->get_stations();

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No stations found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	public function list_transactions() 
	{
		$user_id = $this->input->post('user_id');
		$data = $this->users->get_transactions($user_id);

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No categories found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	//CONTROLLER
	public function insert_cart() 
	{
	
		$user_id = $this->input->post('user_id');
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		$price = $this->input->post('price');
		
		$data = $this->users->set_cart($user_id, $product_id, $quantity, $price);

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "Failed to enter.";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["message"] = "data successfully entered.";

			echo json_encode($return_data);
		}
	}
	
	public function query_cart() 
	{

		$user_id = $this->input->post('user_id');

		$data = $this->users->get_cart($user_id);

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "No product found";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "SUCCESS";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	public function process_deliver() 
	{

		$user_id = $this->input->post('user_id');
		$total_price = $this->input->post('total_price');
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');
		$street_address = $this->input->post('street_address');
		$remarks = $this->input->post('remarks');

		$data = $this->users->insert_transaction($user_id, $total_price, $lat, $lng, $street_address, $remarks);

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "Try again later.";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "SUCCESS";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	public function email()
	{
		$email = $this->input->post('email');
		$code = $this->input->post('code');
		$this->load->library('email');

		$config = array();  


		$config['protocol'] = 'mail';  
		$config['smtp_host'] = 'mail.chynostore.com';  
		$config['smtp_user'] = 'noreply@chynostore.com';  
		$config['smtp_pass'] = 'ryerye';  
		$config['smtp_port'] = 587;  
		$config['newline'] = "\r\n";
		$config['crlf'] = "\r\n";
		$this->email->initialize($config);  
		  


		$this->email->from('noreply@chynostore.com', 'ShopNDeliver by ChynoStore');
		$this->email->to($email);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		$this->email->subject('Email Activation');
		$this->email->message('Welcome to ShopNDeliver by ChynoStore. To proceed, Copy this activation code on your app: '.$code);
		$this->email->send();

		echo $this->email->print_debugger();

	}
	
	
	public function terms_and_conditions()
	{
		$data = $this->users->get_terms();

		if($data == NULL)
		{
			$return_data["status"] = "FAILED";
			$return_data["message"] = "Insert Terms and condition";


			echo json_encode($return_data);
		}
		else 
		{
			$return_data["status"] = "success";
			$return_data["data"] = $data;

			echo json_encode($return_data);
		}
	}
	
	public function is_active()
	{
		$email = $this->input->post('email');
		$data = $this->users->update_is_active($email);

		
		$return_data["status"] = "success";
		$return_data["data"] = $data;

		echo json_encode($return_data);
		
		
	}

	
		
	

}
