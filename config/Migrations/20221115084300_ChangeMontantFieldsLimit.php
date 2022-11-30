<?php
use Migrations\AbstractMigration;

class ChangeMontantFieldsLimit extends AbstractMigration
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

        if ($table->hasColumn('montantlongsejours')) {
            $table->changeColumn('montantlongsejours', 'decimal', [
                'default' => 0.00,
                'precision' => 8,
                'scale' => 2,
            ]);
        }

        if ($table->hasColumn('montantlastminute')) {
            $table->changeColumn('montantlastminute', 'decimal', [
                'default' => 0.00,
                'precision' => 8,
                'scale' => 2,
            ]);
        }

        if ($table->hasColumn('montantearlybooking')) {
            $table->changeColumn('montantearlybooking', 'decimal', [
                'default' => 0.00,
                'precision' => 8,
                'scale' => 2,
            ]);
        }

        $table->update();
    }
}
