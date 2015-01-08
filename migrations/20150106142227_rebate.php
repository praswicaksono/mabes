<?php

use Phinx\Migration\AbstractMigration;

class Rebate extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
     * public function change()
     * {
     * }
     */

    /**
     * Migrate Up.
     */
    public function up()
    {
        if (!$this->hasTable("rebate")) {
            $table = $this->table("rebate", ["id" => false, "primary_key" => "ticket"]);

            $table->addColumn("ticket", "integer")
                ->addColumn("member_id", "integer", ["null" => false])
                ->addColumn("comment", "string", ["null" => false, "limit" => 128])
                ->addColumn("date", "datetime", ["null" => false])
                ->addColumn("rebate", "integer", ["null" => false])
                ->addIndex("date")
                ->create();
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        if ($this->hasTable("rebate")) {
            $this->dropTable("rebate");
        }
    }
}