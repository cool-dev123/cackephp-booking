<?php
use Migrations\AbstractMigration;

class AddApporteranimauxToReservations extends AbstractMigration
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
        $table->addColumn('apporteranimaux', 'integer', [
            'default' => 0,
        ]);
        $table->update();
    }
}
