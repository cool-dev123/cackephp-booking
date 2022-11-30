<?php
use Migrations\AbstractMigration;

class AddBoutiquecorresToVillages extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('villages');
        $table->addColumn('input_boutique', 'string');
        $table->addColumn('input_boutique_EN', 'string');
        $table->update();
    }
}
