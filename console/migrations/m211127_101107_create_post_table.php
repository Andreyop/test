<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m211127_101107_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(255)->notNull(),
            'company_name' => $this->string(255)->notNull(),
            'position' => $this->string(255)->notNull()

        ]);

        $this->createTable('{{%contact_post}}', [
            'post_id' => $this->primaryKey(),
            'contact_name' => $this->string(45)->notNull(),
            'contact_email' => $this->string(255)->notNull(),

        ]);

        $this->createTable('{{%posts_queue}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(11)->notNull(),
            'post_at' => $this->integer(11),
            'notification_sent_at' => $this->integer(11),

        ]);

        $this->createTable('{{%descriptive_post}}', [
            'post_id' => $this->primaryKey(),
            'position_description' => 'MEDIUMTEXT',
            'salary' => $this->integer(11),
            'starts_at' => $this->integer(11),
            'ends_at' => $this->integer(11),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-posts_queue-post_id}}',
            '{{%posts_queue}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-posts_queue-post_id}}',
            '{{%posts_queue}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-descriptive_post-post_id}}',
            '{{%descriptive_post}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-descriptive_post-post_id}}',
            '{{%descriptive_post}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );
        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-contact_post-post_id}}',
            '{{%contact_post}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-contact_post-post_id}}',
            '{{%contact_post}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-posts_queue-post_id}}',
            '{{%posts_queue}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-posts_queue-post_id}}',
            '{{%posts_queue}}'
        );
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-contact_post-post_id}}',
            '{{%contact_post}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-contact_post-post_id}}',
            '{{%contact_post}}'
        );
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-descriptive_post-post_id}}',
            '{{%descriptive_post}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-descriptive_post-post_id}}',
            '{{%descriptive_post}}'
        );
        $this->dropTable('{{%post}}');
        $this->dropTable('{{%contact_post}}');
        $this->dropTable('{{%posts_queue}}');
        $this->dropTable('{{%descriptive_post}}');

    }
}
