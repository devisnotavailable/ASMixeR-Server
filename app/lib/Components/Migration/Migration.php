<?php

declare(strict_types=1);

namespace App\Components\Migration;

/**
 * Class Migration
 * @package App\Components
 */
class Migration extends \yii\db\Migration
{
    /**
     * @param string $table
     *
     * @return bool
     */
    public function tableExists(string $table): bool
    {
        return $this->db->getTableSchema($table, true) !== null;
    }

    /**
     * @param string $table
     */
    public function dropTableIfExist(string $table): void
    {
        if ($this->tableExists($table)) {
            $this->dropTable($table);
        }
    }

    /**
     * @param string $table
     * @param array  $columns
     * @param        $options
     *
     * @return void
     */
    public function createTableIfNotExists(string $table, array $columns, $options = null): void
    {
        if ($this->tableExists($table)) {
            return;
        }

        $this->createTable($table, $columns, $options);
    }

    /**
     * @return string
     */
    public function setTableInnoDbAndUtf8(): string
    {
        return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    }

    /**
     * @return string
     */
    public function getExpressionCurrentTimestamp(): string
    {
        return 'CURRENT_TIMESTAMP';
    }

    public function dropIndex($name, $table): void
    {
        parent::dropIndex($name, $table);
    }

    public function createIndex($name, $table, $columns, $unique = false): void
    {
        parent::createIndex($name, $table, $columns, $unique);
    }
}
