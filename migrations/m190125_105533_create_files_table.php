<?php

use app\migrations\PgsqlMigration;


/**
 * Handles the creation of table `files`.
 */
class m190125_105533_create_files_table extends PgsqlMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('files', [
            'uuid'      => $this->uuid()->notNull(),
            'user_id'   => $this->integer(),
            'content'   => $this->binary(),
            'name'      => $this->string(250),
            'type'      => $this->string(50),
            'size'      => $this->integer(),
            'created_at'=> $this->integer()
        ]);

        // creates index for column `uuid`
        $this->createIndex('files-uuid-idx', 'files', 'uuid');

        // creates index for column `user_id`
        $this->createIndex('files-user_id-idx', 'files', 'user_id');

        // add foreign key for table `user_auth`
        $this->addForeignKey('files-user_id-fk',
            'files', 'user_id',
            'user_auth', 'id',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('files');
    }
}