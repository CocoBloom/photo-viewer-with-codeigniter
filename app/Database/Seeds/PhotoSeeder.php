<?php

namespace App\Database\Seeds;

use App\Models\PhotoModel;
use App\Models\ViewCounterModel;
use CodeIgniter\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Use this method to fill tables before the operations.
     * @return mixed|void
     * @throws \ReflectionException
     */
    public function run()
	{

	    $photosResource = file_get_contents('../resources/photos.json');
	    foreach (json_decode($photosResource, true) as $photo) {
            $photo_data = [
                'caption' => $photo['caption'],
                'photo_credit' => $photo['photo_credit']
            ];
	        $model = new PhotoModel();
            $model->insert($photo_data);
            $insertedID = $model->getInsertID();
            $counterModel = new ViewCounterModel();
            $view_counter_data = [
                'photo_id' => $insertedID,
                'view_counter' => key_exists('view_counter', $photo) ? $photo['view_counter'] : 0
            ];
            $counterModel->protect(false)
                ->insert($view_counter_data);
        }



	}
}
