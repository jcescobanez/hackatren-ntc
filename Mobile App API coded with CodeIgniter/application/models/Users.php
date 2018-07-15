<?php  

class Users extends CI_Model
{


	public function __construct() 
	{
		$this->load->database(); 
		date_default_timezone_set( 'Asia/Manila' );
		parent::__construct();
	}



	public function register_user($password,
			$firstname,
			$lastname,
			$middlename,
			$address,
			$contactnumber,
			$email)
	{
		$pass_encrypt = $this->encryptions->encrypt($password);

		$this -> db -> select('email');
   		$this -> db -> from('user');
   		$this -> db -> where('email', $email);
   		$this -> db -> limit(1);

 		$this->load->database();
   		$query = $this -> db -> get();
 
   		if($query -> num_rows() == 1)
   		{
			return ("failed");
   			
   		}
   		else
   		{

   			$date = date("D M d, Y G:i");

    		 $sql = "INSERT INTO user
			(id, 
				firstname, 
				lastname, 
				middlename, 
				contact_number,
				email,
				password,
				account_no,
				date_issued,
				address,
				is_active) VALUES 
				(''
				,'$firstname',
				'$lastname',
				'$middlename',
				'$contactnumber',
				'$email',
				'$pass_encrypt',
				'2017001',
				'$date',
				'$address',
				'0')";


			$query = $this->db->query($sql);
			return ("success");
   		}
	

	}
	
	public function update_is_active($email) 
	{
		
		$sql = "UPDATE user SET is_active = '1' WHERE email='$email'";
		
		$query = $this->db->query($sql);
		return ("success");

	}
	
	public function update_token($token, $student_no) 
	{
		
		$sql = "UPDATE users SET token = '$token' WHERE username='$student_no'";
		
		$query = $this->db->query($sql);
		return ("success");

	}

	public function get_login_credentials($student_no, $password) 
	{
		
		$sql = "SELECT * FROM users WHERE username='$student_no' AND password='$password' ";
		
		$query = $this->db->query($sql);
		return ($query) ? $query->row() : null;

	}
	
	function get_fruit_price($fruit)
	{
	
	   $this -> db -> select('id, fruitname, fruitprice');
	   $this -> db -> from('tbl_fruits');
	   $this -> db -> where('fruitname', $fruit);
	   $this -> db -> limit(1);
	 
	   $query = $this -> db -> get();
	 
	   if($query -> num_rows() == 1)
	   {
	     return ($query) ? $query->row() : null;
	   }
	   else
	   {
	     
	    return ("FAILED");
	   }
	  
	}
	
	function get_story($command)
	{
	
	   $this -> db -> select('id, command, name, story');
	   $this -> db -> from('tbl_story');
	   $this -> db -> where('command', $command);
	   $this -> db -> limit(1);
	 
	   $query = $this -> db -> get();
	 
	   if($query -> num_rows() == 1)
	   {
	     return ($query) ? $query->row() : null;
	   }
	   else
	   {
	     
	    return ("FAILED");
	   }
	  
	}
	
	public function get_product() 
	{
		return $this->db->get('products')->result();
	}
	
	public function get_stations() 
	{
		return $this->db->get('stations')->result();
	}
	
	
	public function get_fruits() 
	{
		return $this->db->get('tbl_fruits')->result();
	}
	
	public function get_stories() 
	{
		return $this->db->get('tbl_story')->result();
	}
	
	
	public function get_query_product($query , $cat_id) 
	{
		
		
	
   	 	$sql = "SELECT * FROM products
   	 	LEFT JOIN categories on products.cat_id = categories.cat_id
   	 	WHERE products.product_title LIKE '%" . $query . "%' AND products.cat_id = '$cat_id'";
		
		$query = $this->db->query($sql);
		return ($query) ? $query->result() : null;
	}
	
	public function get_query_product_no_cat($query) 
	{
		
		
	
   	 	$sql = "SELECT * FROM products
   	 	LEFT JOIN categories on products.cat_id = categories.cat_id
   	 	WHERE products.product_title LIKE '%" . $query . "%'";
		
		$query = $this->db->query($sql);
		return ($query) ? $query->result() : null;
	}
	
	public function get_categories() 
	{
		
		return $this->db->get('categories')->result();
	}
	
	
	
	public function set_cart($user_id, $product_id, $quantity, $price)
	{
		
		
    		 $sql = "INSERT INTO cart
			(id, 
				user_id, 
				product_id, 
				quantity, 
				price)
				 VALUES 
				(''
				,'$user_id',
				'$product_id',
				'$quantity',
				'$price')";


			$query = $this->db->query($sql);
			return ("success");

	}
	
	public function insert_transaction($user_id, $total_price, $lat, $lng, $street_address, $remarks)
	{
	
	
		$timestamp = date('Y-m-d H:i:s');
		
		
    		 $sql = "INSERT INTO transaction
			(transaction_id, 
				user_id, 
				total_price,
				Date, 
				lat,
				lng,
				street_address, 
				remarks,
				status
				)
				 VALUES 
				(''
				,'$user_id',
				'$total_price',
				'$timestamp',
				'$lat',
				'$lng',
				'$street_address',
				'$remarks',
				'Pending')";
				
		$sql2 = "SELECT transaction_id FROM transaction WHERE transaction_id = LAST_INSERT_ID()";
				
	
			$query = $this->db->query($sql);
			$query = $this->db->query($sql2);
		//	return ("success");
		
			$transaction = ($query) ? $query->row() : null;
			
			foreach($transaction as $row)
			{
    				$testing = $row;
			}
	
		$sql3 = "INSERT INTO customer_orders(order_id, user_id, product_id, qty, total_price, transaction_id)
  			SELECT '', user_id, product_id, quantity, price, '$testing'
    			FROM cart WHERE user_id ='$user_id'";
    			
    			$query = $this->db->query($sql3);
    			
    		$sql4 = "DELETE FROM cart WHERE user_id ='$user_id'";
    			
    			$query = $this->db->query($sql4);


			return "success";
	}
	
	
	public function get_cart($user_id) 
	{
   	 	$sql = "SELECT cart.* , products.product_title, products.product_price
   	 	 FROM cart 
   	 	 LEFT JOIN products ON cart.product_id = products.product_id WHERE cart.user_id='$user_id' ";
		
		$query = $this->db->query($sql);
		return ($query) ? $query->result() : null;
	}
	
	public function remove_cart($user_id, $product_id) 
	{
   	 	$sql = "DELETE FROM cart WHERE user_id='$user_id' AND id='$product_id'";
		
		$query = $this->db->query($sql);
		return "success";
	}
	
	public function get_transactions($user_id) 
	{
   	 	$sql = "SELECT *
   	 	 FROM transaction WHERE user_id='$user_id' ";
		
		$query = $this->db->query($sql);
		return ($query) ? $query->result() : null;
	}
	public function get_terms() 
	{
		return $this->db->get('terms')->result();
	}
	

	
}