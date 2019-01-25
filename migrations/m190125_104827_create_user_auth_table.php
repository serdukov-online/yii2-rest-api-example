<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_auth`.
 */
class m190125_104827_create_user_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_auth', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'username' => $this->string(32),
            'password_hash' => $this->string(64),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        // creates index for column `username`
        $this->createIndex('user_auth-username-idx', 'user_auth', 'username');

        // insert row
        $this->insert('user_auth', [
            'name' => 'Administrator',
            'username' => 'admin',
            'password_hash' => \Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_auth');
    }
}