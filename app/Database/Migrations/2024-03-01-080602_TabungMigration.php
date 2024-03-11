<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabungMigration extends Migration
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
            'category' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'size' => [
                'type' => 'INT',
                'constraint' => 8,
                'default' => 0
            ],
            'weight' => [
                'type' => 'INT',
                'constraint' => 8,
                'default' => 0
            ],
            'stock' => [
                'type' => 'INT',
                'constraint' => 8,
                'default' => 0
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT NULL',
            'deleted_at DATETIME DEFAULT NULL',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tabungs');
    }

    public function down()
    {
        $this->forge->dropTable('tabungs');
    }
}
