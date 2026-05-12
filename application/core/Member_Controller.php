<?php
require_once APPPATH . 'core/MY_Controller.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Member_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->is_logged_in();
		$this->check_role('member');
	}
}
