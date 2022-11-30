<?php
use Migrations\AbstractMigration;

class CreateBlocMailGestionnaires extends AbstractMigration
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
            ->addPrimaryKey('id')
            ->addColumn('gestionnaire_id', 'integer')
            ->addColumn('bloc_info_arrivee', 'text')
            ->addColumn('bloc_info_depart', 'text')
            ->addColumn('bloc_info_horaires', 'text')
            ->addColumn('bloc_service_proprietaire', 'text')
            ->addColumn('bloc_menage_depart', 'text');
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
