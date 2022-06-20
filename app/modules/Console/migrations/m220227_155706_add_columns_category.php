<?php

use App\Components\Migration\Migration;

class m220227_155706_add_columns_category extends Migration
{
    private string $tableName           = 'Category';
    private string $columnDescription   = 'description';
    private string $columnDescriptionRu = 'descriptionRu';

    public function safeUp()
    {
        $this->addColumn($this->tableName, $this->columnDescription, $this->string());
        $this->addColumn($this->tableName, $this->columnDescriptionRu, $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, $this->columnDescription);
        $this->dropColumn($this->tableName, $this->columnDescriptionRu);
    }
}
