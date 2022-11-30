<?php
use Migrations\AbstractMigration;

class CreatePartenaires extends AbstractMigration
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
        $table = $this->table('partenaires');
        //add columns
        $table->addColumn('lieugeo_id','integer')
        ->addColumn('part_code','integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ])
        // ->addColumn('part_id','integer')
        ->addColumn('type','string')
        ->addColumn('type2','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('type3','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('type4','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('type5','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('date_creation','date', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('aContacter','string', ['limit' => 10])
        ->addColumn('langue','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('lat','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('lng','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('forme_juridique','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('raison_sociale','string')
        ->addColumn('genre','string', ['limit' => 10,'null' => true,'default' => null])
        ->addColumn('nom','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('prenom','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('fonction','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('adresse','string')
        ->addColumn('code_postal','integer')
        ->addColumn('ville_id','integer')
        ->addColumn('departement_id','integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ])
        ->addColumn('pays_id','integer')
        ->addColumn('tel','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('portable','string')
        ->addColumn('fax','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('email','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('skype','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('ftp','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('url_adress','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('code_ape','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('siriet','string', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('capital','decimal', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('effectif','integer', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('description','text', [
            'default' => null,
            'null' => true,
        ]);
        //end add columns
        $table->create();
    }
}
