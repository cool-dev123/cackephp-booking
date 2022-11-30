<?php
use Migrations\AbstractMigration;

class AddBanquetterapidoToAnnonces extends AbstractMigration
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
        $table->addColumn('literie_rapido', 'integer', ['default' => 0]);
        $table->addColumn('poele_granule', 'integer', ['default' => 0]);
        $table->update();
    }
}
