<?php

namespace App\Controllers;

use Config\Database;

class Home extends BaseController
{
	public function index()
	{

//	    var_dump("conn<br/>");
//        $db = Database::connect();
//        echo "success";

        return view('welcome_message');
	}
}
