<?php

namespace App\Controllers;
use App\Models\Photo;
use CodeIgniter\RESTful\ResourceController;

class PhotoController extends ResourceController
{
    public function index()
    {
        $model = new Photo();
        $photos = $model->join('view_counters', 'photos.id = view_counters.photo_id')
                        ->findAll();
        return $this->respond($photos);
    }

    public function delete($id = null)
    {
        $model = new Photo();
        $photoExists = $model->find($id);
        if ($photoExists){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Photo is deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No Photo Found with this id: '.$id);
        }
    }

}
