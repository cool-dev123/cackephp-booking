<?php
use Migrations\AbstractMigration;

class AddImageToMassif extends AbstractMigration
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
        $table = $this->table('massif');
        $table->addColumn('image', 'string');
        $table->update();
    }
}
