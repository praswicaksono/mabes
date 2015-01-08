<?php

use Phinx\Migration\AbstractMigration;

class Bank extends AbstractMigration
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
        if (!$this->hasTable("bank")) {
            $table = $this->table("bank", ["id" => "bank_id"]);

            $table->addColumn("bank_id", "integer")
                ->addColumn("bank_name", "string", ["null" => false, "limit" => 64])
                ->addColumn("bank_account", "integer", ["null" => false])
                ->create();
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        if ($this->hasTable("bank")) {
            $this->dropTable("bank");
        }
    }
}