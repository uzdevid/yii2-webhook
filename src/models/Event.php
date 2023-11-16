<?php

namespace uzdevid\webhook\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $name
 *
 * @property HookEvent[] $hookEvents
 */
class Event extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string {
        return 'event';
    }

    /**
     * @return Connection
     * @throws InvalidConfigException
     */
    public static function getDb(): Connection {
        return Yii::$app->get(Yii::$app->webhook->dbName);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[HookEvents]].
     *
     * @return ActiveQuery
     */
    public function getHookEvents(): ActiveQuery {
        return $this->hasMany(HookEvent::class, ['event_id' => 'id']);
    }
}
