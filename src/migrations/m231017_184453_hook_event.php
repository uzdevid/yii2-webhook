<?php

use yii\db\Migration;

/**
 * Class m231017_184453_hook_event
 */
class m231017_184453_hook_event extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('hook_event', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'hook_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_hook_event_event_id', 'hook_event', 'event_id', 'event', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_hook_event_hook_id', 'hook_event', 'hook_id', 'hook', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('hook_event');
        return true;
    }
}
