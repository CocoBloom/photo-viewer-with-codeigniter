<?php

namespace App\Controllers;

use App\Models\ViewCounterModel;
use CodeIgniter\RESTful\ResourceController;

class ViewCounterController extends ResourceController
{
    public function update($photo_id = null)
    {
        try {
            $model = new ViewCounterModel();
            $counterByPhotoID = $this->getCounterByPhotoID($photo_id);
            $newCounter = [
                'photo_id' => $photo_id,
                'view_counter' => $counterByPhotoID + 1
            ];

            $model->protect(false)
                ->save($newCounter);

            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Counter is increased.'
                ]
            ];
            return $this->respondCreated($response);
        } catch (\Exception $e) {
            return $this->failNotFound($e->getMessage());
        }
    }

    protected function getCounterByPhotoID($photo_id)
    {
        $model = new ViewCounterModel();
        $view_counterByPhotoID = $model->getWhere(['photo_id' => $photo_id])->getResult();
        return intval($view_counterByPhotoID[0]->view_counter);
    }

}