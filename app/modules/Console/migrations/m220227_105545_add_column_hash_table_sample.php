<?php

use App\Components\Migration\Migration;

class m220227_105545_add_column_hash_table_sample extends Migration
{
    private string $tableName = 'Sample';
    private string $columnName= 'uuid';

    public function safeUp()
    {
        $this->addColumn($this->tableName, $this->columnName, $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, $this->columnName);
    }
}
