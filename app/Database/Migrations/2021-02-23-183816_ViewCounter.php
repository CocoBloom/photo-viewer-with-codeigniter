<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ViewCounter extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'photo_id' => [
                'type'           => 'INT',
                'unique'         => true
            ],
            'view_counter' => [
                'type'           => 'INT',
                'default'        => 0
            ]
        ]);

        $this->forge->addPrimaryKey('photo_id')->addForeignKey('photo_id', 'photos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('view_counters', true);

        $this->db->enableForeignKeyChecks();
    }

	public function down()
	{
        $this->forge->dropTable('view_counters', true);
    }
}
