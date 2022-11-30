<?php
use Migrations\AbstractMigration;

class AddHeaderToLieugeos extends AbstractMigration
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
        $table = $this->table('lieugeos');
        $table->addColumn('image_header_ete', 'string');
        $table->addColumn('image_header_hiver', 'string');
        $table->addColumn('RM_id', 'integer');
        $table->update();
    }
}
