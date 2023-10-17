<?php

namespace common\models\db\base;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "hook".
 *
 * @property int $id
 * @property string $url
 * @property string $events
 * @property string $auth
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
     * {@inheritdoc}
     */
    public function rules(): array {
        return [
            [['url', 'events', 'auth'], 'required'],
            [['events', 'auth'], 'safe'],
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
            'events' => 'Events',
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
