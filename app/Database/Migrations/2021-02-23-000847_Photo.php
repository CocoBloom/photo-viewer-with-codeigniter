<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Photo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'photo_credit' => [
                'type' => 'TEXT'
            ],
            'caption' => [
                'type' => 'TEXT'
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('photos');

    }

    public function down()
    {
        $this->forge->dropTable('photos');
    }
}
