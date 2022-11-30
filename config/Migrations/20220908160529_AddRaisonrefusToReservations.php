<?php
use Migrations\AbstractMigration;

class AddRaisonrefusToReservations extends AbstractMigration
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
        $table->addColumn('raison_refus', 'integer', [
            'default' => 0,
        ]);
        $table->update();
    }
}
