<?php

namespace App\Controllers;

use App\Models\ViewCounterModel;
use CodeIgniter\RESTful\ResourceController;

/**
 * Class ViewCounterController
 * Provides operations with view_counters table.
 * @package App\Controllers
 */
class ViewCounterController extends ResourceController
{
    /**
     * Update a view_counter value by photo_id.
     * @param null $photo_id
     * @return mixed
     */
    public function update($photo_id = null)
    {
        try {
            $model = new ViewCounterModel();
            $counterByPhotoID = self::getCounterByPhotoID($photo_id);
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

    /**
     * Get view_counter value by photo_id.
     * @param $photo_id
     * @return int
     */
    public static function getCounterByPhotoID($photo_id)
    {
        $model = new ViewCounterModel();
        $view_counterByPhotoID = $model->getWhere(['photo_id' => $photo_id])->getResult();
        return intval($view_counterByPhotoID[0]->view_counter);
    }
}