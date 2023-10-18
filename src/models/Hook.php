<?php

namespace uzdevid\webhook\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;

/**
 * This is the model class for table "hook".
 *
 * @property int $id
 * @property string $url
 * @property array $auth
 *
 * @property Attempt[] $attempts
 * @property HookEvent[] $hookEvents
 */
class Hook extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string {
        return 'hook';
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
            [['url', 'auth'], 'required'],
            [['auth'], 'safe'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'auth' => 'Auth',
        ];
    }

    /**
     * Gets query for [[Attempts]].
     *
     * @return ActiveQuery
     */
    public function getAttempts(): ActiveQuery {
        return $this->hasMany(Attempt::class, ['hook_id' => 'id']);
    }

    /**
     * Gets query for [[HookEvents]].
     *
     * @return ActiveQuery
     */
    public function getHookEvents(): ActiveQuery {
        return $this->hasMany(HookEvent::class, ['hook_id' => 'id']);
    }
}
