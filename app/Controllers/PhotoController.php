<?php

namespace App\Controllers;
use App\Models\Photo;
use CodeIgniter\RESTful\ResourceController;

class PhotoController extends ResourceController
{
    public function index()
    {
        $model = new Photo();
        $photos = $model->select(['id', 'caption', 'photo_credit', 'view_counter'])
            ->join('view_counters', 'photos.id = view_counters.photo_id')
            ->findAll();
        return $this->respond($photos);
    }

}
