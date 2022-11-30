<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Utilisateur'), ['action' => 'edit', $utilisateur->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Utilisateur'), ['action' => 'delete', $utilisateur->id], ['confirm' => __('Are you sure you want to delete # {0}?', $utilisateur->id)]) ?> </li>
        <li><?= $this->Html->link(__('Liste des utilisateurs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nouvel utilisateur'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="utilisateurs view large-9 medium-8 columns content">
    <h3><?= h($utilisateur->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Code Client') ?></th>
            <td><?= h($utilisateur->code_client) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($utilisateur->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Mot Passe') ?></th>
            <td><?= h($utilisateur->mot_passe) ?></td>
        </tr>
        <tr>
            <th><?= __('Priv') ?></th>
            <td><?= h($utilisateur->priv) ?></td>
        </tr>
        <tr>
            <th><?= __('Civilite') ?></th>
            <td><?= h($utilisateur->civilite) ?></td>
        </tr>
        <tr>
            <th><?= __('Prenom') ?></th>
            <td><?= h($utilisateur->prenom) ?></td>
        </tr>
        <tr>
            <th><?= __('Nom de famille') ?></th>
            <td><?= h($utilisateur->nom_famille) ?></td>
        </tr>
        <tr>
            <th><?= __('Societe') ?></th>
            <td><?= h($utilisateur->societe) ?></td>
        </tr>
        <tr>
            <th><?= __('Telephone') ?></th>
            <td><?= h($utilisateur->telephone) ?></td>
        </tr>
        <tr>
            <th><?= __('Fax') ?></th>
            <td><?= h($utilisateur->fax) ?></td>
        </tr>
        <tr>
            <th><?= __('Portable') ?></th>
            <td><?= h($utilisateur->portable) ?></td>
        </tr>
        <tr>
            <th><?= __('Adresse') ?></th>
            <td><?= h($utilisateur->adresse) ?></td>
        </tr>
        <tr>
            <th><?= __('Code Postal') ?></th>
            <td><?= h($utilisateur->code_postal) ?></td>
        </tr>
        <tr>
            <th><?= __('Ville') ?></th>
            <td><?= h($utilisateur->ville) ?></td>
        </tr>
        <tr>
            <th><?= __('Format') ?></th>
            <td><?= h($utilisateur->format) ?></td>
        </tr>
        <tr>
            <th><?= __('Siret') ?></th>
            <td><?= h($utilisateur->siret) ?></td>
        </tr>
        <tr>
            <th><?= __('Ape') ?></th>
            <td><?= h($utilisateur->ape) ?></td>
        </tr>
        <tr>
            <th><?= __('Code Banque') ?></th>
            <td><?= h($utilisateur->code_banque) ?></td>
        </tr>
        <tr>
            <th><?= __('Code Guichet') ?></th>
            <td><?= h($utilisateur->code_guichet) ?></td>
        </tr>
        <tr>
            <th><?= __('Numero Compte') ?></th>
            <td><?= h($utilisateur->numero_compte) ?></td>
        </tr>
        <tr>
            <th><?= __('Cle Rib') ?></th>
            <td><?= h($utilisateur->cle_rib) ?></td>
        </tr>
        <tr>
            <th><?= __('Domiciliation') ?></th>
            <td><?= h($utilisateur->domiciliation) ?></td>
        </tr>
        <tr>
            <th><?= __('Iban') ?></th>
            <td><?= h($utilisateur->iban) ?></td>
        </tr>
        <tr>
            <th><?= __('Bic') ?></th>
            <td><?= h($utilisateur->bic) ?></td>
        </tr>
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= h($utilisateur->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Message Client') ?></th>
            <td><?= h($utilisateur->message_client) ?></td>
        </tr>
        <tr>
            <th><?= __('Nom Utilisateur') ?></th>
            <td><?= h($utilisateur->nom_utilisateur) ?></td>
        </tr>
        <tr>
            <th><?= __('Region') ?></th>
            <td><?= h($utilisateur->region) ?></td>
        </tr>
        <tr>
            <th><?= __('Ident') ?></th>
            <td><?= h($utilisateur->ident) ?></td>
        </tr>
        <tr>
            <th><?= __('Pwd') ?></th>
            <td><?= h($utilisateur->pwd) ?></td>
        </tr>
        <tr>
            <th><?= __('Statut Coupon') ?></th>
            <td><?= h($utilisateur->statut_coupon) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($utilisateur->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Adr2') ?></th>
            <td><?= h($utilisateur->adr2) ?></td>
        </tr>
        <tr>
            <th><?= __('Adr3') ?></th>
            <td><?= h($utilisateur->adr3) ?></td>
        </tr>
        <tr>
            <th><?= __('Nature') ?></th>
            <td><?= h($utilisateur->nature) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($utilisateur->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Pays') ?></th>
            <td><?= $this->Number->format($utilisateur->pays) ?></td>
        </tr>
        <tr>
            <th><?= __('Cnil') ?></th>
            <td><?= $this->Number->format($utilisateur->cnil) ?></td>
        </tr>
        <tr>
            <th><?= __('Newsletter') ?></th>
            <td><?= $this->Number->format($utilisateur->newsletter) ?></td>
        </tr>
        <tr>
            <th><?= __('Commercial') ?></th>
            <td><?= $this->Number->format($utilisateur->commercial) ?></td>
        </tr>
        <tr>
            <th><?= __('Remise Percent') ?></th>
            <td><?= $this->Number->format($utilisateur->remise_percent) ?></td>
        </tr>
        <tr>
            <th><?= __('Remise Valeur') ?></th>
            <td><?= $this->Number->format($utilisateur->remise_valeur) ?></td>
        </tr>
        <tr>
            <th><?= __('Points') ?></th>
            <td><?= $this->Number->format($utilisateur->points) ?></td>
        </tr>
        <tr>
            <th><?= __('Avoir') ?></th>
            <td><?= $this->Number->format($utilisateur->avoir) ?></td>
        </tr>
        <tr>
            <th><?= __('Etat') ?></th>
            <td><?= $this->Number->format($utilisateur->etat) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Parrain') ?></th>
            <td><?= $this->Number->format($utilisateur->id_parrain) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Groupe') ?></th>
            <td><?= $this->Number->format($utilisateur->id_groupe) ?></td>
        </tr>
        <tr>
            <th><?= __('Prof Yn') ?></th>
            <td><?= $this->Number->format($utilisateur->prof_yn) ?></td>
        </tr>
        <tr>
            <th><?= __('Statut') ?></th>
            <td><?= $this->Number->format($utilisateur->statut) ?></td>
        </tr>
        <tr>
            <th><?= __('Info Cle Yn') ?></th>
            <td><?= $this->Number->format($utilisateur->info_cle_yn) ?></td>
        </tr>
        <tr>
            <th><?= __('Info Ctt Yn') ?></th>
            <td><?= $this->Number->format($utilisateur->info_ctt_yn) ?></td>
        </tr>
        <tr>
            <th><?= __('Offres Promo Yn') ?></th>
            <td><?= $this->Number->format($utilisateur->offres_promo_yn) ?></td>
        </tr>
        <tr>
            <th><?= __('Club Alpissime') ?></th>
            <td><?= $this->Number->format($utilisateur->club_alpissime) ?></td>
        </tr>
        <tr>
            <th><?= __('Sms') ?></th>
            <td><?= $this->Number->format($utilisateur->sms) ?></td>
        </tr>
        <tr>
            <th><?= __('Naissance') ?></th>
            <td><?= h($utilisateur->naissance) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Insert') ?></th>
            <td><?= h($utilisateur->date_insert) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Update') ?></th>
            <td><?= h($utilisateur->date_update) ?></td>
        </tr>
        <tr>
            <th><?= __('Accept At') ?></th>
            <td><?= h($utilisateur->accept_at) ?></td>
        </tr>
        <tr>
            <th><?= __('Valide At') ?></th>
            <td><?= h($utilisateur->valide_at) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($utilisateur->message)); ?>
    </div>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($utilisateur->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Alerte') ?></h4>
        <?= $this->Text->autoParagraph(h($utilisateur->alerte)); ?>
    </div>
</div>
