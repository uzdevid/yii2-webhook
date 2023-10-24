<?php

namespace uzdevid\webhook\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;

/**
 * This is the model class for table "attempt".
 *
 * @property int $id
 * @property int $hook_id
 * @property int $job_id
 * @property int $attempt
 * @property string $event_name
 * @property string $event_time
 * @property string $method
 * @property string $url
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
            [['hook_id', 'job_id', 'event_name', 'event_time', 'method', 'url', 'payload', 'response', 'status', 'create_time'], 'required'],
            [['hook_id', 'job_id', 'attempt', 'status'], 'default', 'value' => null],
            [['hook_id', 'job_id', 'attempt', 'status'], 'integer'],
            [['event_time', 'payload', 'create_time'], 'safe'],
            [['response'], 'string'],
            [['event_name', 'url'], 'string', 'max' => 255],
            [['method'], 'string', 'max' => 10],
            [['hook_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hook::class, 'targetAttribute' => ['hook_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hook_id' => 'Hook ID',
            'job_id' => 'Job ID',
            'attempt' => 'Attempt',
            'event_name' => 'Event Name',
            'event_time' => 'Event Time',
            'method' => 'Method',
            'url' => 'Url',
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
