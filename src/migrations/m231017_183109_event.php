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
            'id' => $this->string(255)->notNull()->unique(),
            'hook_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_event_id', 'event', 'id');
        $this->addForeignKey('fk_event_hook_id', 'event', 'hook_id', 'hook', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool {
        $this->dropTable('event');
        return true;
    }
}
