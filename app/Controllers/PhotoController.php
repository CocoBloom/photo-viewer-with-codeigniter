<?php

namespace App\Controllers;
use App\Models\PhotoModel;
use App\Models\ViewCounterModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\RESTful\ResourceController;

/**
 * Class PhotoController
 * PhotoController provides operations with Photos table for displaying or changing data.
 * @package App\Controllers
 */
class PhotoController extends ResourceController
{
    /**
     * Join photos table with view_counters to get view_counter value of each photo.
     * @return mixed
     */
    public function index()
    {
        try {
            $model = new PhotoModel();
            $photos = $model->select(['id', 'caption', 'photo_credit', 'view_counter'])
                            ->join('view_counters', 'photos.id = view_counters.photo_id')
                            ->findAll();
            return $this->respond($photos);
        } catch (DatabaseException $e) {
            return $this->failNotFound($e->getMessage());
        }
    }

    /**
     * Delete method for delete a row from table.
     * @param null $id
     * @return mixed
     */
    public function delete($id = null)
    {
        try {
            $model = new PhotoModel();
            $photoExists = $model->find($id);
            if ($photoExists) {
                $model->delete($id);
                $response = [
                    'status' => 200,
                    'error' => null,
                    'messages' => [
                        'success' => 'PhotoModel is deleted'
                    ]
                ];
                return $this->respondDeleted($response);
            } else {
                return $this->failNotFound('No PhotoModel Found with this id: ' . $id);
            }
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /**
     * Add a new Photo into photos table and a new ViewCounter row with the id of previously created Photo.
     * @return mixed
     */
    public function create()
    {
        $model = new PhotoModel();
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
                    'success' => 'New PhotoModel is saved.'
                ],
                'newPhotoID' => $insertedID
            ];
            return $this->respondCreated($response);
        } catch (\Exception $e) {
            return $this->failNotFound($e->getMessage());
        }
    }

    /**
     * Implement show method to get a Photo from photos table by ID.
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new PhotoModel();
        $photo = $model->getWhere(['id' => $id])->getResult();
        if($photo){
            return $this->respond($photo);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }

    /**
     * Update a specified Photo's data.
     * @param null $id
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new PhotoModel();
        $newCaption = $this->request->getVar('caption');
        $newPhoto_credit = $this->request->getVar('photo_credit');
        $newData = [
            'caption' => $newCaption,
            'photo_credit' => $newPhoto_credit
        ];

        try{
            $model->protect(false)
                ->update($id,$newData);
            $view_counter = ViewCounterController::getCounterByPhotoID($id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'PhotoModel is updated.'
                ],
                'newPhotoID' => $id,
                'view_counter' => $view_counter
            ];
            return $this->respondCreated($response);
        } catch (\Exception $e) {
            return $this->failNotFound($e->getMessage());
        }
    }
}
