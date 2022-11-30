<?php
use Migrations\AbstractMigration;

class CreateAnnulationReservations extends AbstractMigration
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
        $table = $this->table('annulation_reservations')
            ->addPrimaryKey('id')
            ->addColumn('justificatif', 'integer')
            ->addColumn('motif_annulation','string')            
            ->addColumn('file', 'string')
            ->addColumn('commentaire', 'text')
            ->addColumn('reservation_id', 'integer');
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
