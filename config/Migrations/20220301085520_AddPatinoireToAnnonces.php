<?php
use Migrations\AbstractMigration;

class AddPatinoireToAnnonces extends AbstractMigration
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
        $table = $this->table('annonces')
            ->addColumn('patinoire', 'integer');
        $table->update();
    }
}
