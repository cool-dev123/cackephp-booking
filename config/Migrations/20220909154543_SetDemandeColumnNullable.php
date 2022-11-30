<?php
use Migrations\AbstractMigration;

class SetDemandeColumnNullable extends AbstractMigration
{
    public function up()
    {
        $this->query("ALTER TABLE contactprops MODIFY demande varchar(255) NULL;");
    }

    public function down()
    {
        $this->query("ALTER TABLE contactprops MODIFY demande varchar(255) NOT NULL;");
    }
}
