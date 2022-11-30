<?php
use Migrations\AbstractMigration;

class UpdateWiFiAnnouces extends AbstractMigration
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
        //Add new temporary column
        $table = $this->table('annonces');
        $table->addColumn('wifi_new', 'integer', [
            'default' => 0,
            'after' => 'wifi',
            'null' => true,
        ]);
        $table->update();
        //Update all announces
        $this->query("UPDATE `annonces` SET wifi_new = ((CASE WHEN wifi = 1 THEN 1 ELSE 0 END) | (CASE WHEN wifi_gratuit = 1 THEN 2 ELSE 0 END) | (CASE WHEN  wifi_payant = 1 THEN 4 ELSE 0 END));");

        $table->renameColumn('wifi', '_wifi_appartment');
        $table->renameColumn('wifi_gratuit', '_wifi_gratuit');
        $table->renameColumn('wifi_payant', '_wifi_payant');
        $table->renameColumn('wifi_new', 'wifi');
    }
}
