<?php
use Migrations\AbstractMigration;

class AddPayerToAnnulationReservations extends AbstractMigration
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
        $table = $this->table('annulation_reservations');
        $table->addColumn('payer', 'integer', ['default' => 0]);
        $table->update();
    }
}
