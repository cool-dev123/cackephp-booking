<?php
use Migrations\AbstractMigration;

class CreateOfficeTourisme extends AbstractMigration
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
        $table = $this->table('office_tourisme');
        $table->addColumn('village_id','integer',['null' => true,'default' => null,]);
        $table->addColumn('type', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('nom', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('lien', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('categorie', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('code_postal', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('adresse', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('latitude', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('longitude', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('email','string');
        $table->addColumn('tel','string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('portable','string');
        $table->addColumn('email_pro','string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('tel_pro','string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('telecopie','string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('skype','string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('adreesse2','string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->create();
    }
}
