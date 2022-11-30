<?php
use Migrations\AbstractMigration;

class CreateNumeroUtiles extends AbstractMigration
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
        $table = $this->table('numero_utiles')
            ->addColumn('nom','string')
            ->addColumn('id_lieugeo','integer')
            ->addColumn('number','string')
            ->addColumn('email','string')
            ->addColumn('latitude','string')
            ->addColumn('longitude','string')
            ->addColumn('id_bibliotheque','integer')
            ->create();
    }
}
