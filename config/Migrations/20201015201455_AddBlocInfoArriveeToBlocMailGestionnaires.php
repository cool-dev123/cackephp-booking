<?php
use Migrations\AbstractMigration;

class AddBlocInfoArriveeToBlocMailGestionnaires extends AbstractMigration
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
        $table = $this->table('bloc_mail_gestionnaires')
            ->addColumn('bloc_info_arrivee_en', 'text')
            ->addColumn('bloc_info_depart_en', 'text')
            ->addColumn('bloc_info_horaires_en', 'text')
            ->addColumn('bloc_service_proprietaire_en', 'text')
            ->addColumn('bloc_menage_depart_en', 'text');
        $table->update();
    }
}
