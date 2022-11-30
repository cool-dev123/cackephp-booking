<?php
use Migrations\AbstractMigration;

class AddInputboutiqueToLieugeos extends AbstractMigration
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
        $table->addColumn('input_boutique', 'string');
        $table->addColumn('input_blog', 'string');
        $table->update();
    }
}
