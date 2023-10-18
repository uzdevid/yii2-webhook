<?php

namespace uzdevid\webhook\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "hook_event".
 *
 * @property int $id
 * @property int $event_id
 * @property int $hook_id
 *
 * @property Event $event
 * @property Hook $hook
 */
class HookEvent extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string {
        return 'hook_event';
    }

    /**
     * @return Connection
     */
    public static function getDb(): Connection {
        return Yii::$app->get(Yii::$app->webhook->dbName);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array {
        return [
            [['event_id', 'hook_id'], 'required'],
            [['event_id', 'hook_id'], 'default', 'value' => null],
            [['event_id', 'hook_id'], 'integer'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
            [['hook_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hook::class, 'targetAttribute' => ['hook_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'hook_id' => 'Hook ID',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return ActiveQuery
     */
    public function getEvent(): ActiveQuery {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

    /**
     * Gets query for [[Hook]].
     *
     * @return ActiveQuery
     */
    public function getHook(): ActiveQuery {
        return $this->hasOne(Hook::class, ['id' => 'hook_id']);
    }
}
