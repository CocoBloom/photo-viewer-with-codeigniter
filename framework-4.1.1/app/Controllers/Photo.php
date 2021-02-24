<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use function PHPUnit\Framework\returnArgument;

class Photo extends BaseController
{

    public function index()
	{
        $builder = $this->db_connection->table('photos');
        $builder->select(['id', 'caption', 'photo_credit', 'view_counter']);
        $builder->join('view_counters', 'photos.id = view_counters.photo_id');
        $query = $builder->get();
        if (!empty($query->getResult())) {
            return ($this->response->setBody($query->getResultArray()));
        } else {
            return $this->response->setBody("No photos in the database");

        }
	}

	public function show($id)
    {
        $builder = $this->db_connection->table("photos");
        $query = $builder->getWhere(['id' => $id]);
        if (!empty($query->getResult())) {
            return $this->response->setBody($query->getResultArray());
        } else {
            return $this->response->setBody("Photo with this id doesn't exist.");
        }
    }

}
