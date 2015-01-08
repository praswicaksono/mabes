<?php

use Phinx\Migration\AbstractMigration;

class Member extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        if (!$this->hasTable("member")) {
            $table = $this->table("member", [
                    "id" => false,
                    "primary_key" => ["member_id"]
                ]);

            $table->addColumn("member_id", "integer", ["null" => false])
                ->addColumn("full_name", "string", ["null" => false, "limit" => 128])
                ->addColumn("country", "string", ["null" => false, "limit" => 64])
                ->addColumn("phone", "string", ["null" => false, "limit" => 32])
                ->addColumn("email", "string", ["null" => false, "limit" => 64])
                ->addColumn("register_date", "date", ["null" => false])
                ->addIndex(["email"], ["unique" => true])
                ->create();
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        if ($this->hasTable("member")) {
            $this->dropTable("member");
        }
    }
}