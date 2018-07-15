<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Encryption library...
class Encryptions {

	// Method for encrypting the data...
	// The ecryption used is SHA256
	public function encrypt($value)
	{	
		return hash('SHA256', $value);
	}

}