<?php
use Migrations\AbstractMigration;

class AddEarlybookingToAnnonces extends AbstractMigration
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
        $table->addColumn('proposerearlybooking', 'integer', [
            'default' => 0,
        ]);
        $table->addColumn('delaisearly', 'integer', [
            'default' => 0,
        ]);
        $table->addColumn('montantearlybooking', 'decimal', [
            'default' => 0,
            'limit' => '8,2',
        ]);
        $table->update();
    }
}
