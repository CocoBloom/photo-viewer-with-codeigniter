<?php

namespace App\Controllers;
use App\Models\Photo;
use App\Models\ViewCounterModel;
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

    public function create()
    {
        $model = new Photo();
        $counterModel = new ViewCounterModel();
        $newCapt = $this->request->getVar('caption');
        $newCredit = $this->request->getVar('photo_credit');
        $data = [
            'caption' => $newCapt,
            'photo_credit' => $newCredit
        ];

        try{
            $model->protect(false)
                  ->insert($data);
            $insertedID = $model->getInsertID();

            $counterModel->protect(false)
                         ->insert(['photo_id' => $insertedID]);

            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'New Photo is saved.'
                ],
                'newPhotoID' => $insertedID
            ];
            return $this->respondCreated($response);
        } catch (\Exception $e) {
            return $this->failNotFound($e->getMessage());
        }
    }

    public function show($id = null)
    {
        $model = new Photo();
        $photo = $model->getWhere(['id' => $id])->getResult();
        if($photo){
            return $this->respond($photo);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }

    }
}
