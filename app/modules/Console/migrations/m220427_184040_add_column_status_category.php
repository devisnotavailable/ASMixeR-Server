<?php

use App\Components\Migration\Migration;
use App\Models\Category;

class m220427_184040_add_column_status_category extends Migration
{
    private string $tableName = 'Category';
    private string $columnName = 'status';

    public function safeUp()
    {
        $this->addColumn($this->tableName, $this->columnName, $this->string(50)->defaultValue(Category::STATUS_NO_APPROVE));
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, $this->columnName);
    }
}
