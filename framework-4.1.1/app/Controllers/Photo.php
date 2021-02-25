<?php

namespace App\Controllers;


class Photo extends BaseController
{
    protected $photosTable = '';
    protected $counterTable = '';

    public function __construct()
    {
        $this->photosTable = 'photos';
        $this->counterTable = 'view_counters';
    }

    public function index()
	{
        $builder = $this->db_connection->table($this->photosTable);
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
        $builder = $this->db_connection->table($this->photosTable);
        $query = $builder->getWhere(['id' => $id]);
        if (!empty($query->getResult())) {
            return $this->response->setBody(["data" => $query->getResultArray()]);
        } else {
            return $this->response->setBody(["message"=> "Photo with this id doesn't exist."]);
        }
    }

    public function delete($id)
    {
        $builder = $this->db_connection->table($this->photosTable);
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
        $builder = $this->db_connection->table($this->photosTable);
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
        $builder = $this->db_connection->table($this->counterTable);
        $builder->insert($data);
        var_dump($this->db_connection->affectedRows() === 1);
        return $this->db_connection->affectedRows() === 1;
    }

    //TODO increase counter

    public function update($photo_id)
    {
        $counterByPhoto = $this->getCounterByPhotoID($photo_id);
        if ($counterByPhoto !== -1) {
            $data = [
                'view_counter' => $counterByPhoto + 1
            ];
            $builder = $this->db_connection->table($this->counterTable);
            $builder->where('photo_id', $photo_id);
            $builder->update($data);
            if ($this->db_connection->affectedRows() === 1) {
                var_dump($this->response->setBody(["data" => true]));
            } else {
                var_dump($this->response->setBody(["data" => false]));
            }
        } else {
            return $this->response->setBody(["data" => false]);
        }
    }

    protected function getCounterByPhotoID($photo_id)
    {
        $builder = $this->db_connection->table($this->counterTable);
        $query = $builder->getWhere(['photo_id' => $photo_id]);
        if (!empty($query->getResult())) {
            return $query->getResultArray()[0]['view_counter'];
        } else {
            return -1;
        }
    }

    //todo update/edit photo data
}
