<?php

use App\Components\Migration\Migration;

class m220228_171550_add_indexes extends Migration
{
    private string $tableCategory = 'Category';
    private string $tableSample   = 'Sample';

    private string $indexCategory = 'names_iconPath';
    private string $indexSample   = 'name_uuid_status';

    public function safeUp()
    {
        $this->createIndex($this->indexCategory, $this->tableCategory, ['name', 'nameRu']);
        $this->createIndex($this->indexSample, $this->tableSample, ['name', 'uuid', 'status']);
    }

    public function safeDown()
    {
        $this->dropIndex($this->indexCategory, $this->tableCategory);
        $this->dropIndex($this->indexSample, $this->tableSample);
    }
}
