<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter TextMarketer Library
 * 
 * Author: Chris Harvey (Movie Notifications)
 * Website: http://www.chrisnharvey.com
 * Email: chris@chrisnharvey.com
 *
 * Originally developed for Movie Notifications (http://www.movienotifications.com)
 * 
 **/
 
class Textmarketer {
	private $URL = "http://www.textmarketer.biz/gateway/"; 
	private $SHORT_CODE="88802";
	private $using_short_code=false;
 	private $my_url;
	private $error;
	private $remaining_credits,$credits_used;
	private $transaction_id;
 
	
	function __construct()
	{
		$this->_CI =& get_instance();
		$this->_CI->load->config("textmarketer");
		
		$this->my_url = $this->URL."?username=".$this->_CI->config->item('api_username')."&password=".$this->_CI->config->item('api_password')."&option=xml";
	}

	
	public function send($number,$message,$originator = NULL)
	{
		$originator = ($originator === NULL) ? $this->_CI->config->item('default_from') : $originator;	

		$this->error = null;

		$query_string = "&number=".$number;
		$query_string .= "&message=".urlencode($message);

		$query_string .= "&orig=".urlencode($originator);

		$fp =fopen($this->my_url.$query_string,"r");
		$response = fread($fp,1024);

		return $this->process_response($response);
	}
	
	public function get_error()
	{
		$arr = each($this->error);
		return $arr['value'];
	}
	
	public function remaining_credits()
	{
		return $this->ramaining_credits;
	}
	
	public function transaction_id()
	{
		return $this->transaction_id;
	}

	// Get the number of credits used to send the message - 1 message = 160 characters
	public function credits_used()
	{
		return $this->credits_used;
	}

	// Private funcs
	private function process_response($response)
	{
		$xml=simplexml_load_string($response);
		if ($xml['status'] == "failed")
		{
			foreach($xml->reason as $index => $reason)
				$this->error[] = $reason;
			
			return FALSE;
		}
		else
		{
			$this->transaction_id = $xml['id'];
			$this->remaining_credits = $xml->credits;
			$this->credits_used = $xml->credits_used;
			
			return TRUE;
		}
		
	}
}