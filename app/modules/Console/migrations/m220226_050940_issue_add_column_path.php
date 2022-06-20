<?php

use App\Components\Migration\Migration;

class m220226_050940_issue_add_column_path extends Migration
{
    private string $tableName = 'Category';
    private string $columnName = 'iconPath';

    public function safeUp()
    {
        $this->addColumn($this->tableName, $this->columnName, $this->string(512));
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, $this->columnName);
    }
}
