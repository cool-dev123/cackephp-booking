<?php
use Migrations\AbstractMigration;

class CreateStatistiquetauxremplissage extends AbstractMigration
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
        $table = $this->table('statistiquetauxremplissage')
                ->addPrimaryKey('id')                
                ->addColumn('nbr_annonce_active', 'biginteger')
                ->addColumn('nbr_lit_lie', 'biginteger');
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
