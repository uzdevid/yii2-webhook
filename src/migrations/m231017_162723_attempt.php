<?php

use yii\db\Migration;

/**
 * Class m231017_162723_attempt
 */
class m231017_162723_attempt extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('attempt', [
            'id' => $this->primaryKey(),
            'hook_id' => $this->integer()->notNull(),
            'job_id' => $this->integer()->notNull(),
            'attempt' => $this->integer()->notNull()->defaultValue(1),
            'method' => $this->string(10)->notNull(),
            'url' => $this->string(255)->notNull(),
            'event_name' => $this->string(255)->notNull(),
            'event_time' => $this->dateTime()->notNull(),
            'payload' => $this->json()->notNull(),
            'response' => $this->text()->notNull(),
            'status' => $this->tinyInteger(3)->notNull(),
            'create_time' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey('fk_attempt_hook_id', 'attempt', 'hook_id', 'hook', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool {
        $this->dropTable('attempt');
        return true;
    }
}
