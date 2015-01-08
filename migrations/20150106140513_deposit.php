<?php

use Phinx\Migration\AbstractMigration;

class Deposit extends AbstractMigration
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
        if (!$this->hasTable("deposit")) {
            $table = $this->table("deposit", [
                    "id" => false,
                    "primary_key" => "deposit_id"
                ]);

            $table->addColumn("deposit_id", "integer")
                ->addColumn("amount_usd", "ineteger", ["null" => false])
                ->addColumn("amount_idr", "integer", ["null" => false])
                ->addColumn("member_id", "integer", ["null" => false])
                ->addColumn("transfer_to", "integer", ["null" => false])
                ->addColumn("transfer_from", "string", ["null" => false, "limit" => 16])
                ->addColumn("account_number", "integer", ["null" => false])
                ->addColumn("account_name", "string", ["null" => false, "limit" => 64])
                ->addColumn("email", "string", ["null" => false, "limit" => 64])
                ->addColumn("phone", "integer", ["null" => false])
                ->addColumn("status", "integer", ["null" => false])
                ->addColumn("created_at", "datetime")
                ->addColumn("updated_at", "datetime")
                ->addIndex(["created_at", "updated_at"])
                ->create();
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        if ($this->hasTable("deposit")) {
            $this->dropTable("deposit");
        }
    }
}