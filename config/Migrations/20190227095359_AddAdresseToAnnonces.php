<?php
use Migrations\AbstractMigration;

class AddAdresseToAnnonces extends AbstractMigration
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
        $table->addColumn('code_postal','integer')
                ->addColumn('pays','integer')
                ->addColumn('ville','integer')
                ->addColumn('region','integer');
        $table->update();
    }
}
