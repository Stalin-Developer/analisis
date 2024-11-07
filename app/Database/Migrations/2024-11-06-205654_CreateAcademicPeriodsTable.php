<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAcademicPeriodsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'start_date' => [
                'type'       => 'VARCHAR', // Cambiado de DATE a VARCHAR
                'constraint' => '50',      // Agregado constraint
            ],
            'end_date' => [
                'type'       => 'VARCHAR', // Cambiado de DATE a VARCHAR
                'constraint' => '50',      // Agregado constraint
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey(['start_date', 'end_date'], false, 'idx_academic_periods_dates');
        $this->forge->createTable('academic_periods');
    }

    public function down()
    {
        $this->forge->dropTable('academic_periods');
    }
}