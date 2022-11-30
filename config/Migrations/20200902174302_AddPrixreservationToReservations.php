<?php
use Migrations\AbstractMigration;

class AddPrixreservationToReservations extends AbstractMigration
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
        $table->addColumn('prixreservation', 'float');
        $table->addColumn('prixtaxesejour', 'float');
        $table->addColumn('prixfraiservice', 'float');
        $table->update();
    }
}
