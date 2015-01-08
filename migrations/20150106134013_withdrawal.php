<?php

use Phinx\Migration\AbstractMigration;

class Withdrawal extends AbstractMigration
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
        if (!$this->hasTable("withrawal")) {
            $table = $this->table("withrawal", ["id" => false, "primary_key" => "withdrawal_id"]);

            $table->addColumn("withdrawal_id", "string", ["null" => false, "limit" => 64])
                ->addColumn("member_id", "integer", ["null" => false])
                ->addColumn("amount", "integer", ["null" => false])
                ->addColumn("phone_password", "string", ["null" => false, "limit" => 16])
                ->addColumn("bank_name", "string", ["null" => false, "limit" => 16])
                ->addColumn("bank_account", "integer", ["null" => false])
                ->addColumn("account_name", "string", ["null" => false, "limit" => 64])
                ->addColumn("email", "string", ["null" => false])
                ->addColumn("phone", "integer", ["null" => false])
                ->addColumn("status", "integer", ["null" => false])
                ->addColumn("created_at", "datetime", ["null" => true])
                ->addColumn("updated_at", "datetime", ["null" => false])
                ->addIndex(["updated_at", "created_at"])
                ->addForeignKey("member_id", "member", "member_id")
                ->create();
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        if ($this->hasTable("withdrawal")) {
            $this->dropTable("withdrawal");
        }
    }
}