<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PeminjamanMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
            ],
            'loan_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'mitra_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'tabung_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'amount' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => 0
            ],
            'approval' => [
                'type' => 'ENUM',
                'constraint' => ['approved', 'rejected'],
                'default' => NULL
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['waiting', 'sent', 'done'],
                'default' => NULL
            ],
            'address_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT NULL',
            'deleted_at DATETIME DEFAULT NULL',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('mitra_id', 'mitras', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('tabung_id', 'tabungs', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('address_id', 'addresses', 'id', '', 'CASCADE');
        $this->forge->createTable('peminjamans');
    }

    public function down()
    {
        $this->forge->dropTable('peminjamans');
    }
}
