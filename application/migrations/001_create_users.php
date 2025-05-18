<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users extends CI_Migration {

    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'unique'     => TRUE,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => TRUE,
            ],
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE,
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->dbforge->add_key('id', TRUE); // Primary key
        $this->dbforge->create_table('users');
    }

    public function down() {
        $this->dbforge->drop_table('users');
    }
}
