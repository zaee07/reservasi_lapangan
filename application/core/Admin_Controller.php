<?php

// use MY_Controller;

require_once APPPATH . 'core/MY_Controller.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->is_logged_in();
		$this->check_role('admin_cabang');
	}
}
