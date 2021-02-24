<?php

namespace App\Controllers;

use Config\Database;

class Photo extends BaseController
{
	public function index()
	{
        $builder = Database::connect()->table('photos');
        $builder->select(['id', 'caption', 'photo_credit', 'view_counter']);
        $builder->join('view_counters', 'photos.id = view_counters.photo_id');
        $query = $builder->get();
        return $query->getResultArray();
	}




}
