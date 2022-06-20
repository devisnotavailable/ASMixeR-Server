<?php

use App\Components\Migration\Migration;

class m220110_075719_issue_create_tables_sample_category extends Migration
{
    private string $tableCategory       = 'Category';
    private string $tableSample         = 'Sample';
    private string $tableCategorySample = 'CategorySample';
    private string $tableFeedbacks      = 'Feedback';

    public function safeUp()
    {
        $this->createTableIfNotExists($this->tableCategory, [
            'id'           => $this->primaryKey(),
            'name'         => $this->string(512),
            'dateCreated'  => $this->timestamp()->defaultExpression($this->getExpressionCurrentTimestamp()),
            'dateLastEdit' => $this->timestamp()->null(),
        ], $this->setTableInnoDbAndUtf8());

        $this->createTableIfNotExists($this->tableSample, [
            'id'           => $this->primaryKey(),
            'name'         => $this->string(512),
            'path'         => $this->string(),
            'dmca'         => $this->boolean(),
            'dateCreated'  => $this->timestamp()->defaultExpression($this->getExpressionCurrentTimestamp()),
            'dateLastEdit' => $this->timestamp()->null(),
        ], $this->setTableInnoDbAndUtf8());

        $this->createTableIfNotExists($this->tableCategorySample, [
            'id'         => $this->primaryKey(),
            'sampleId'   => $this->integer(),
            'categoryId' => $this->integer(),
        ], $this->setTableInnoDbAndUtf8());

        $this->createTableIfNotExists($this->tableFeedbacks, [
            'id'          => $this->primaryKey(),
            'text'        => $this->text(),
            'dateCreated' => $this->timestamp()->defaultExpression($this->getExpressionCurrentTimestamp()),
        ], $this->setTableInnoDbAndUtf8());
    }

    public function safeDown()
    {
        $this->dropTableIfExist($this->tableCategory);
        $this->dropTableIfExist($this->tableSample);
        $this->dropTableIfExist($this->tableCategorySample);
        $this->dropTableIfExist($this->tableFeedbacks);
    }
}
