<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'image' => [
                'type' => 'MEDIUMTEXT',
                'null' => true,
                'default' => 'uploads/default/default.png',
            ],
            'id_role' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => false,
                'default' => 1,
            ],
            'reset_token' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'reset_expiry' => [
                'type' => 'INT',
                'constraint' => 150,
                'null' => true,
                'default' => 0,
            ],
            'no_hp' => [
                'type' => 'INT',
                'constraint' => 15,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
