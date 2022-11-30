<?php
use Migrations\AbstractMigration;

class AlterPrixapayerOnReservations extends AbstractMigration
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
        $table = $this->table('reservations');
        $table->changeColumn('prixapayer', 'float', [
            'default' => 0,
            'null' => true,
        ]);
        $table->changeColumn('prixreservation', 'float', [
            'default' => 0,
            'null' => true,
        ]);
        $table->changeColumn('prixtaxesejour', 'float', [
            'default' => 0,
            'null' => true,
        ]);
        $table->changeColumn('prixfraiservice', 'float', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
