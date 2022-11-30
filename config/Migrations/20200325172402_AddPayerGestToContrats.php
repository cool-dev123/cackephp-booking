<?php
use Migrations\AbstractMigration;

class AddPayerGestToContrats extends AbstractMigration
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
        $table = $this->table('contrats');
        $table->addColumn('payerGest', 'integer', [
            'default' => 1,
        ]);  
        $table->addColumn('id_produit_contrat_boutique', 'string', [
            'default' => null,
        ]);       
        $table->update();
    }
}
