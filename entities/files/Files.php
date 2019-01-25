<?php

namespace app\entities\files;


use app\entities\users\User;
use Ramsey\Uuid\Uuid;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Files
 * @package app\entities\files
 * @property string $uuid [uuid]
 * @property string $user_id [integer]
 * @property string $content [bytea]
 * @property string $name [varchar(250)]
 * @property string $type [varchar(50)]
 * @property string $size [integer]
 * @property string $created_at [integer]
 * @property null|\app\entities\users\User $user
 */
class Files extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'uuid',
            'name',
            'type',
            'size',
            'created_at' => function(self $model) {
                return date('d.m.Y H:i:s', $model->created_at);
            },
            'created_by' => function(self $model) {
                return $model->user->name;
            }
        ];
    }

    /**
     * Создание файла
     * @param mixed $user_id
     * @param string $content
     * @param string $name
     * @param string $type
     * @param int $size
     * @return Files
     */
    public static function create($user_id, string $content, string $name, string $type, int $size)
    {
        $model = new self();
        $model->uuid    = Uuid::uuid4()->toString();
        $model->user_id = $user_id;
        $model->content = $content;
        $model->name    = $name;
        $model->type    = $type;
        $model->size    = $size;

        return $model;
    }

    /**
     * Модель пользователя
     * @return User|null
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => time(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    /**
     * @return array
     */
    public static function primaryKey()
    {
        return ['uuid'];
    }
}