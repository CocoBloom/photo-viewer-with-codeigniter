<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;

class Photo extends BaseController
{
    protected $tableName = '';
    protected $viewerTableName;

    public function __construct()
    {
        $this->tableName = 'photos';
        $this->viewerTableName = 'view_counters';
    }

    public function index()
	{
        $builder = $this->db_connection->table($this->tableName);
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
        $builder = $this->db_connection->table($this->tableName);
        $query = $builder->getWhere(['id' => $id]);
        if (!empty($query->getResult())) {
            return $this->response->setBody(["data" => $query->getResultArray()]);
        } else {
            return $this->response->setBody(["message"=> "Photo with this id doesn't exist."]);
        }
    }

    public function delete($id)
    {
        $builder = $this->db_connection->table($this->tableName);
        $builder->where('id', intval($id));
        $builder->delete();
        if (1 === $this->db_connection->affectedRows()) {
            return $this->response->setBody(["data" => true]);
        } else {
            return $this->response->setBody(["data" => false]);
        }
    }

    public function create()
    {
        $data = $this->request->getPost();
        $builder = $this->db_connection->table($this->tableName);
        $builder->insert($data);
        if ($this->db_connection->affectedRows() === 1 && $this->createPhotoViewerRow($this->db_connection->mysqli->insert_id)) {
            return $this->response->setBody(["data" => true]);
        } else {
            return $this->response->setBody(["data" => false]);
        }
    }

    public function createPhotoViewerRow($id): bool
    {
        $data = [
            "photo_id" => $id,
            "view_counter" => 0
        ];
        $builder = $this->db_connection->table($this->viewerTableName);
        $builder->insert($data);
        return $this->db_connection->affectedRows() === 1;
    }
}
