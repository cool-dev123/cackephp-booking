<?php
use Migrations\AbstractMigration;

class AddHeaderimagesToMassif extends AbstractMigration
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
        $table->addColumn('image_header_ete', 'string');
        $table->addColumn('image_header_hiver', 'string');
        $table->update();
    }
}
