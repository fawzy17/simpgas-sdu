<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MitraMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tubes_borrowed' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => 0
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'deleted_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('mitras');
    }

    public function down()
    {
        $this->forge->dropTable('mitras');
    }
}
