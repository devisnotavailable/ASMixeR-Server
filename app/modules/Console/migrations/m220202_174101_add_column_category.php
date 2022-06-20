<?php

use App\Components\Migration\Migration;

class m220202_174101_add_column_category extends Migration
{
    private string $tableName  = 'Category';
    private string $columnName = 'nameRu';

    public function safeUp()
    {
        $this->addColumn($this->tableName, $this->columnName, $this->string(512));
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, $this->columnName);
    }
}