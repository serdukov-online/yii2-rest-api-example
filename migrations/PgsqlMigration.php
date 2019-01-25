<?php

namespace app\migrations;


use yii\db\Migration;

abstract class PgsqlMigration extends Migration
{
    /** @const string */
    const TYPE_UUID = 'uuid';

    /**
     * Creates a uuid column.
     * @return ColumnSchemaBuilder the column instance which can be further customized.
     */
    public function uuid()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder(self::TYPE_UUID);
    }
}