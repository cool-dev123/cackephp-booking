<?php
use Migrations\AbstractMigration;

class CreateFeedbackresponses extends AbstractMigration
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
        $table = $this->table('feedbackresponses', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['autoIncrement' => true])
              ->addColumn('reponse', 'text')
              ->addColumn('utilisateur_id', 'integer')
              ->addColumn('feedback_id', 'integer');
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
