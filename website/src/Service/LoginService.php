<?php 

namespace ldahinden\Service;

interface LoginService {
	/**
	 * 
	 * @param unknown $username
	 * @param unknown $password
	 * @return boolean
	 */
	public function authenticate($username, $password);
}

?>