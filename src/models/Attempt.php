<?php

namespace uzdevid\webhook\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "attempt".
 *
 * @property int $id
 * @property int $hook_id
 * @property int $attempt
 * @property string $event_name
 * @property string $event_time
 * @property string $payload
 * @property string $response
 * @property int $status
 * @property string $create_time
 *
 * @property Hook $hook
 */
class Attempt extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string {
        return 'attempt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array {
        return [
            [['hook_id', 'event_name', 'event_time', 'payload', 'response', 'status', 'create_time'], 'required'],
            [['hook_id', 'attempt', 'status'], 'default', 'value' => null],
            [['hook_id', 'attempt', 'status'], 'integer'],
            [['event_time', 'payload', 'create_time'], 'safe'],
            [['response'], 'string'],
            [['event_name'], 'string', 'max' => 255],
            [['hook_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hook::class, 'targetAttribute' => ['hook_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array {
        return [
            'id' => 'ID',
            'hook_id' => 'Hook ID',
            'attempt' => 'Attempt',
            'event_name' => 'Event Name',
            'event_time' => 'Event Time',
            'payload' => 'Payload',
            'response' => 'Response',
            'status' => 'Status',
            'create_time' => 'Create Time',
        ];
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
