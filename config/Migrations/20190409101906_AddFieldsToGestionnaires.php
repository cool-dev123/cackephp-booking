<?php
use Migrations\AbstractMigration;

class AddFieldsToGestionnaires extends AbstractMigration
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
        $table = $this->table('gestionnaires');
        $table->addColumn('descriptif_activité', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('station_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('genre', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('raison_sociale', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('prenom', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('type', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('pays_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('departements_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('mobile', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('adresse_du_site', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('code_APE', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('siret', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}