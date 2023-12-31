<?php

use yii\db\Migration;

/**
 * Class m231017_183109_event
 */
class m231017_183109_event extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()
        ]);

        $this->createIndex('idx_event_event', 'event', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool {
        $this->dropTable('event');
        return true;
    }
}
