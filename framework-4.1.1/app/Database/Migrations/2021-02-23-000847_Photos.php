<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Photos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'caption' => [
                'type' => 'TEXT'
            ],
            'photo_credit' => [
                'type' => 'TEXT'
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('photos');

    }

    public function down()
    {
        $this->forge->dropTable('photos', true);
    }
}
