<?php

namespace App\Controllers;

use Config\Database;

class Home extends BaseController
{
	public function index()
	{
        return view('welcome_message');
	}
}
