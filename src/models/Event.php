<?php

namespace common\models\db\base;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
