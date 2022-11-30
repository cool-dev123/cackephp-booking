<?php
use Migrations\AbstractMigration;

class AddCautionToAnnonces extends AbstractMigration
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
        $table = $this->table('annonces');
        $table->addColumn('caution', 'integer');
        $table->update();
    }
}
