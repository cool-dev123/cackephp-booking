<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UtilisateursFixture
 *
 */
class UtilisateursFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'code_client' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'mot_passe' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'priv' => ['type' => 'string', 'length' => 5, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'civilite' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'prenom' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'nom_famille' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'societe' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'naissance' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'telephone' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'fax' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'portable' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'adresse' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'code_postal' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'ville' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'pays' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cnil' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'newsletter' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'commercial' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'remise_percent' => ['type' => 'float', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'remise_valeur' => ['type' => 'float', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'points' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'format' => ['type' => 'string', 'length' => 5, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'message' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'siret' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'ape' => ['type' => 'string', 'length' => 5, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'code_banque' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'code_guichet' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero_compte' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'cle_rib' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'domiciliation' => ['type' => 'string', 'length' => 180, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'iban' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'bic' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'url' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'message_client' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'date_insert' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'date_update' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'alerte' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'nom_utilisateur' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'region' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'ident' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'pwd' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'avoir' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'statut_coupon' => ['type' => 'string', 'length' => 125, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'etat' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_parrain' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_groupe' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'adr2' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'adr3' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'nature' => ['type' => 'string', 'length' => 4, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'accept_at' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'prof_yn' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valide_at' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'statut' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'info_cle_yn' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'info_ctt_yn' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'offres_promo_yn' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'club_alpissime' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sms' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'code_client' => ['type' => 'index', 'columns' => ['code_client'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'email'], 'length' => []],
            'nom_utilisateur' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'code_client' => 'Lorem ipsum dolor sit amet',
            'email' => '796bc469-a1b3-4533-b0b1-7652bc3da394',
            'mot_passe' => 'Lorem ipsum dolor sit amet',
            'priv' => 'Lor',
            'civilite' => 'Lorem ipsum dolor sit amet',
            'prenom' => 'Lorem ipsum dolor sit amet',
            'nom_famille' => 'Lorem ipsum dolor sit amet',
            'societe' => 'Lorem ipsum dolor sit amet',
            'naissance' => '2016-02-15',
            'telephone' => 'Lorem ipsum dolor sit amet',
            'fax' => 'Lorem ipsum dolor sit amet',
            'portable' => 'Lorem ipsum dolor sit amet',
            'adresse' => 'Lorem ipsum dolor sit amet',
            'code_postal' => 'Lorem ipsum dolor sit amet',
            'ville' => 'Lorem ipsum dolor sit amet',
            'pays' => 1,
            'cnil' => 1,
            'newsletter' => 1,
            'commercial' => 1,
            'remise_percent' => 1,
            'remise_valeur' => 1,
            'points' => 1,
            'format' => 'Lor',
            'message' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'siret' => 'Lorem ipsum dolor ',
            'ape' => 'Lor',
            'code_banque' => 'Lorem ipsum d',
            'code_guichet' => 'Lorem ipsum d',
            'numero_compte' => 'Lorem ipsum d',
            'cle_rib' => 'Lorem ipsum d',
            'domiciliation' => 'Lorem ipsum dolor sit amet',
            'iban' => 'Lorem ipsum dolor sit amet',
            'bic' => 'Lorem ipsum dolor sit amet',
            'url' => 'Lorem ipsum dolor sit amet',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'message_client' => 'Lorem ipsum dolor sit amet',
            'date_insert' => '2016-02-15 14:06:49',
            'date_update' => '2016-02-15 14:06:49',
            'alerte' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'nom_utilisateur' => 'Lorem ipsum dolor sit amet',
            'region' => 'Lorem ipsum dolor sit amet',
            'ident' => 'Lorem ipsum dolor sit amet',
            'pwd' => 'Lorem ipsum dolor sit amet',
            'avoir' => 1,
            'statut_coupon' => 'Lorem ipsum dolor sit amet',
            'type' => 'Lorem ip',
            'etat' => 1,
            'id_parrain' => 1,
            'id_groupe' => 1,
            'adr2' => 'Lorem ipsum dolor sit amet',
            'adr3' => 'Lorem ipsum dolor sit amet',
            'nature' => 'Lo',
            'accept_at' => '2016-02-15',
            'prof_yn' => 1,
            'valide_at' => '2016-02-15',
            'statut' => 1,
            'info_cle_yn' => 1,
            'info_ctt_yn' => 1,
            'offres_promo_yn' => 1,
            'club_alpissime' => 1,
            'sms' => 1
        ],
    ];
}
