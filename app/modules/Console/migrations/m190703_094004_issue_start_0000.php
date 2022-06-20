<?php

use App\Components\Migration\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;
use yii\rbac\ManagerInterface;

/**
 *
 * @property ManagerInterface $authManager
 */
class m190703_094004_issue_start_0000 extends Migration
{
    public string $table_user = '{{%user}}';

    public function safeUp()
    {
        $this->createTableIfNotExists($this->table_user, [
            'id'              => $this->primaryKey(),
            'username'        => $this->string()->unique(),
            'hash_password'   => $this->string(),
            'auth_key'        => $this->string()->unique(),
            'access_token'    => $this->string()->unique(),
            'email'           => $this->string()->unique(),
            'phone'           => $this->string(),
            'type'            => $this->boolean(),
            'status'          => $this->boolean(),
            'date_created'    => $this->timestamp()->defaultExpression($this->getExpressionCurrentTimestamp()),
            'date_updated'    => $this->timestamp(),
            'date_last_visit' => $this->timestamp(),
        ], $this->setTableInnoDbAndUtf8());

        /** @var DbManager $authManager */
        $authManager = $this->getAuthManager();

        $this->createTableIfNotExists($authManager->ruleTable, [
            'name'       => $this->string(64)->notNull(),
            'data'       => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ], $this->setTableInnoDbAndUtf8());

        $this->createTableIfNotExists($authManager->itemTable, [
            'name'        => $this->string(64)->notNull(),
            'type'        => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name'   => $this->string(64),
            'data'        => $this->text(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $authManager->ruleTable . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $this->setTableInnoDbAndUtf8());
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

        $this->createTableIfNotExists($authManager->itemChildTable, [
            'parent' => $this->string(64)->notNull(),
            'child'  => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $this->setTableInnoDbAndUtf8());

        $this->createTableIfNotExists($authManager->assignmentTable, [
            'item_name'  => $this->string(64)->notNull(),
            'user_id'    => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $this->setTableInnoDbAndUtf8());
    }

    /**
     * @return ManagerInterface
     * @throws InvalidConfigException
     */
    protected function getAuthManager(): ManagerInterface
    {
        $authManager = \Yii::$app->getAuthManager();

        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

    public function safeDown()
    {
        /** @var DbManager $authManager */
        $authManager = $this->getAuthManager();

        $this->dropTableIfExist($this->table_user);
        $this->dropTableIfExist($authManager->assignmentTable);
        $this->dropTableIfExist($authManager->itemChildTable);
        $this->dropTableIfExist($authManager->itemTable);
        $this->dropTableIfExist($authManager->ruleTable);
    }
}