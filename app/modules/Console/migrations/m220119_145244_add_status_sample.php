<?php

use App\Components\Migration\Migration;
use App\Models\Sample;

class m220119_145244_add_status_sample extends Migration
{
    private string $tableName = 'Sample';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'status', $this->string(50)->defaultValue(Sample::STATUS_NO_APPROVE));
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'status');
    }
}
