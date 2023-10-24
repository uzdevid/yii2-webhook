<?php

namespace uzdevid\webhook\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\helpers\ArrayHelper;

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
    public array $events = [];

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
            [['auth', 'events'], 'safe'],
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

    public function afterFind(): void {
        parent::afterFind();

        $this->auth = json_encode($this->auth, JSON_UNESCAPED_UNICODE);
        $this->events = ArrayHelper::getColumn($this->hookEvents, 'event_id');
    }

    /**
     * @param $insert
     *
     * @return mixed
     */
    public function beforeSave($insert): bool {
        if (is_string($this->auth)) {
            $this->auth = json_decode($this->auth, true);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes): void {
        HookEvent::deleteAll(['hook_id' => $this->id]);

        foreach ($this->events as $event) {
            $hookEvent = new HookEvent();
            $hookEvent->hook_id = $this->id;
            $hookEvent->event_id = $event;
            $hookEvent->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return mixed
     */
    public function allEvents(): array {
        return ArrayHelper::map(Event::find()->all(), 'id', 'name');
    }
}
