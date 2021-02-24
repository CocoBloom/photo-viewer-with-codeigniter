<?php

namespace App\Controllers;

use Config\Database;

class Photo extends BaseController
{
    protected $db_connection;

    public function __construct()
    {
        $this->db_connection = Database::connect();
    }

    public function index()
	{
        $builder = $this->db_connection->table('photos');
        $builder->select(['id', 'caption', 'photo_credit', 'view_counter']);
        $builder->join('view_counters', 'photos.id = view_counters.photo_id');
        $query = $builder->get();
        return $query->getResultArray();
	}


}
