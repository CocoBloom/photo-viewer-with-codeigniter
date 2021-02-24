<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use function PHPUnit\Framework\returnArgument;

class Photo extends BaseController
{
    protected $tableName = '';

    public function __construct()
    {
        $this->tableName = 'photos';
    }

    public function index()
	{
        $builder = $this->db_connection->table('photos');
        $builder->select(['id', 'caption', 'photo_credit', 'view_counter']);
        $builder->join('view_counters', 'photos.id = view_counters.photo_id');
        $query = $builder->get();
        if (!empty($query->getResult())) {
            return $this->response->setBody(["data" => $query->getResultArray()]);
        } else {
            return $this->response->setBody(["message" => "No photos in the database"]);
        }
	}

	public function show($id)
    {
        $builder = $this->db_connection->table("photos");
        $query = $builder->getWhere(['id' => $id]);
        if (!empty($query->getResult())) {
            return $this->response->setBody(["data" => $query->getResultArray()]);
        } else {
            return $this->response->setBody(["message"=> "Photo with this id doesn't exist."]);
        }
    }

    public function delete($id)
    {
        echo gettype($id)."\n".$this->tableName."\n";
        $builder = $this->db_connection->table($this->tableName);
        $builder->where('id', intval($id));
        $builder->delete();
        if (0 === $this->db_connection->affectedRows()) {
            var_dump($this->response->setBody(["data" => false]));
        } else {
            var_dump($this->response->setBody(["data" => true]));
        }
    }
}
