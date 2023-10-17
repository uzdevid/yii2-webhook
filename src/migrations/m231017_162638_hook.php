<?php

use yii\db\Migration;

/**
 * Class m231017_162638_hook
 */
class m231017_162638_hook extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('hook', [
            'id' => $this->primaryKey(),
            'url' => $this->string(255)->notNull(),
            'auth' => $this->json()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool {
        $this->dropTable('hook');
        return true;
    }
}
