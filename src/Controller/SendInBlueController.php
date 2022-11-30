<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\AttributesApi;
use \SendinBlue\Client\Model\CreateAttribute;
use GuzzleHttp\Client;
use SendinBlue\Client\Api\ContactsApi;
use \SendinBlue\Client\Model\CreateContact;
use Cake\I18n\Time;
use SendinBlue\Client\Api\ListsApi;
use DateTime;
use \SendinBlue\Client\Model\UpdateContact;
use \SendinBlue\Client\Model\AddContactToList;
use \SendinBlue\Client\Model\RemoveContactFromList;
use GuzzleHttp\Exception\RequestException;


/**
 * SendInBlueController Controller
 *
 *
 * @method \App\Model\Entity\SendInBlueController[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SendInBlueController extends AppController
{
  /**
   * $MY_KEY attribute : the api key of SendInBlue
   */
  public $MY_KEY ;


  function __construct() {
        parent::__construct();
        $this->MY_KEY = "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";
        // $this->MY_KEY = "";
    }
    
    public function getContactInfo($email) {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ContactsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );

        try {
            $result = $apiInstance->getContactInfo($email);
            if($result == null)                return null;
            else                return $result->getAttributes();
        } catch (Exception $e) {
            echo 'Exception when calling ContactsApi->getContactInfo: ', $e->getMessage(), PHP_EOL;
        }
    }
    /**
     * getListIdByName method
     *
     * @param string|null $name Name of List.
     * @return Id of the list.
     */
    public function getListIdByName($name){
            $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ListsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );

        try {
            $result = $apiInstance->getLists();
            foreach ($result['lists'] as $list) {
              if($list['name']==$name){
                return $list['id'];
              }
            }
        } catch (Exception $e) {
            return 'Exception when calling ListsApi->getLists: '. $e->getMessage(). PHP_EOL;
        }
    }

    /**
     * addContactToList method
     *
     * @param string|null $ContactEmail Email of contact.
     * @param string|null $ListName Nom de la liste.
     * @return true if the movement is succeed.
     */
    public function addContactToList($ContactEmail, $ListName){
            $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ContactsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );
        $listId = $ListName; // int | Id of the list
        $contactEmails = new AddContactToList(['emails'=>[$ContactEmail]]); // \SendinBlue\Client\Model\AddContactToList | Emails addresses of the contacts

        try {
            $result = $apiInstance->addContactToList($listId, $contactEmails);
            return true;
        } catch (Exception $e) {
            return 'Exception when calling ContactsApi->addContactToList: '. $e->getMessage(). PHP_EOL;
        }
    }

     /**
     * removeContactFromList method
     *
     * @param string|null $ContactEmail Email of contact.
     * @param string|null $ListName Nom de la liste.
     * @return true if the movement is succeed.
     */
    public function removeContactFromList($ContactEmail, $ListName){
            $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ContactsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );
        $listId = $this->getListIdByName($ListName); // int | Id of the list
        $contactEmails = new RemoveContactFromList(['emails'=>[$ContactEmail]]); // \SendinBlue\Client\Model\RemoveContactFromList | Emails adresses of the contact

        try {
            $result = $apiInstance->removeContactFromList($listId, $contactEmails);
            return true;
        } catch (Exception $e) {
            return 'Exception when calling ContactsApi->removeContactFromList: '. $e->getMessage(). PHP_EOL;
        }
    }

     /**
     * addContactToSendInBlue method
     *
     * @param string|null $EMAIL Email of contact.
     * @param string|null $PRENOM prenom of contact.
     * @param string|null $NOM_FAMILLE nom of contact.
     * @param string|null $SMS N° téléphonne international of contact.
     * @param string|null $CIVILITE CIVILITE of contact .
     * @param string|null $NAISSANCE birth date of contact.
     * @param string|null $ADRESSE physical adress of contact.
     * @param string|null $CODE_POSTAL postal code of contact.
     * @param string|null $VILLE city of contact.
     * @param string|null $PAYS country of contact.
     * @param string|null $NATURE role of contact.
     */
    public function addContactToSendInBlue($EMAIL,$PRENOM=null,$NOM_FAMILLE=null,$SMS=null,$CIVILITE=null,$NAISSANCE=null,$ADRESSE=null,$CODE_POSTAL=null,$VILLE=null,$PAYS=null,$NATURE=null){
      set_time_limit(3000);
      
      if( strpos($SMS, '+') == -1|| strpos($SMS, '(') != false){
        $SMS=$this->getFormatFrenchPhoneNumber($SMS,true);
      }
      if ($SMS == "" )$SMS=null;

            // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ContactsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );
        $idlist=$NATURE == 'CLT' ? 32 : 33;
        $createContact = new CreateContact(['email'=>$EMAIL ,
         'attributes'=>[
              'PRENOM'=>$PRENOM,
              'NOM'=>$NOM_FAMILLE,
              'SMS'=>str_replace(' ','',$SMS),
              'CIVILITE'=>$CIVILITE,
              'DATE_NAISSANCE'=>$NAISSANCE!=null?$NAISSANCE->format('Y-m-d'):$NAISSANCE,
              'ADRESSE'=>$ADRESSE,
              'CODE_POSTAL'=>$CODE_POSTAL,
              'VILLE'=>$VILLE,
              'PAYS'=>$PAYS,
          ],
        'listIds' => array($idlist) ,
        ]); // \SendinBlue\Client\Model\CreateContact | Values to create a contact
        
            $result = $apiInstance->getContactInfo($EMAIL);
            if ($result!=null){
                    $listName=$NATURE == 'CLT' ? 32 : 33;
                    $this->addContactToList($EMAIL, $listName);
                    $this->updateContactToSendInBlue($EMAIL,$PRENOM,$NOM_FAMILLE,$SMS,$CIVILITE,$NAISSANCE,$ADRESSE,$CODE_POSTAL,$VILLE,$PAYS);
                    return true;
                }
            try {
                $result = $apiInstance->createContact($createContact);
                return true;
            } catch (RequestException $e) {
                //return 'Exception when calling ContactsApi->createContact: '. $e->getMessage(). PHP_EOL;
              }
  }

    /**
     * updateContactToSendInBlue method
     *
     * @param string|null $EMAIL Email of contact.
     * @param string|null $PRENOM prenom of contact.
     * @param string|null $NOM_FAMILLE nom of contact.
     * @param string|null $SMS N°téléphonne international of contact.
     * @param string|null $CIVILITE CIVILITE of contact .
     * @param string|null $NAISSANCE birth date of contact.
     * @param string|null $ADRESSE physical adress of contact.
     * @param string|null $CODE_POSTAL postal code of contact.
     * @param string|null $VILLE city of contact.
     * @param string|null $PAYS country of contact.
     */
    public function updateContactToSendInBlue($EMAIL,$PRENOM=null,$NOM_FAMILLE=null,$SMS=null,$CIVILITE=null,$NAISSANCE=null,$ADRESSE=null,$CODE_POSTAL=null,$VILLE=null,$PAYS=null){
            // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ContactsApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
        new Client(),
        $config
        );
        $attributes = [];

        if($PRENOM!=null) $attributes['PRENOM'] = $PRENOM;
        if($NOM_FAMILLE!=null) $attributes['NOM'] = $NOM_FAMILLE;
        if($SMS!=null) $attributes['SMS'] = $SMS;
        if($CIVILITE!=null) $attributes['CIVILITE'] = $CIVILITE;
        if($NAISSANCE!=null) $attributes['DATE_NAISSANCE'] = $NAISSANCE->format('Y-m-d');
        if($ADRESSE!=null) $attributes['ADRESSE'] = $ADRESSE;
        if($CODE_POSTAL!=null) $attributes['CODE_POSTAL'] = $CODE_POSTAL;
        if($VILLE!=null) $attributes['VILLE'] = $VILLE;
        if($PAYS!=null) $attributes['PAYS'] = $PAYS;

        //dd($attributes);

        $updateContact = new UpdateContact(['attributes'=>$attributes]); // \SendinBlue\Client\Model\UpdateContact | Values to update a contact

           try {
            $result = $apiInstance->getContactInfo($EMAIL);
            if ($result!=null){
            $apiInstance->updateContact($EMAIL, $updateContact);
            }
            return true;
        } catch (Exception $e) {
            return 'Exception when calling ContactsApi->updateContact: '. $e->getMessage(). PHP_EOL;
        }
        
    }

    /**
     * updateContactEmail method
     *
     * @param string|null $oldEMAIL the old Email of contact.
     * @param string|null $newEmail the new Email of contact.
     * @param string|null $PRENOM prenom of contact.
     * @param string|null $NOM_FAMILLE nom of contact.
     * @param string|null $SMS N°téléphonne international of contact.
     * @param string|null $CIVILITE CIVILITE of contact .
     * @param string|null $NAISSANCE birth date of contact.
     * @param string|null $ADRESSE physical adress of contact.
     * @param string|null $CODE_POSTAL postal code of contact.
     * @param string|null $VILLE city of contact.
     * @param string|null $PAYS country of contact.
     * @param string|null $NATURE role of contact.
     */
    public function updateContactEmail($oldEMAIL,$newEmail,$PRENOM=null,$NOM_FAMILLE=null,$SMS=null,$CIVILITE=null,$NAISSANCE=null,$ADRESSE=null,$CODE_POSTAL=null,$VILLE=null,$PAYS=null,$NATURE=null){
            // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ContactsApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
        new Client(),
        $config
        );

        try {
            $result = $apiInstance->getContactInfo($oldEMAIL);
            if ($result!=null){
                $apiInstance->deleteContact($oldEMAIL);
            }
            return true;
        } catch (Exception $e) {
            return 'Exception when calling ContactsApi->deleteContact: '. $e->getMessage(). PHP_EOL;
        }
        
        $this->addContactToSendInBlue($newEmail,$PRENOM,$NOM_FAMILLE,$SMS,$CIVILITE,$NAISSANCE,$ADRESSE,$CODE_POSTAL,$VILLE,$PAYS,$NATURE);
    }
    
    public function deleteContact($email){
        // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ContactsApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
        new Client(),
        $config
        );
        
        try {
            $result = $apiInstance->getContactInfo($email);
            if ($result==true){
                $res=$apiInstance->deleteContact($email);
                return $res;
            }
        } catch (Exception $e) {
            return 'Exception when calling ContactsApi->deleteContact: '. $e->getMessage(). PHP_EOL;
        }
        return true;
        
    }

    /**
     * addContactNewslettreToSendInBlue method
     *
     * @param string|null $EMAIL Email of contact.
     * @param string|null $PRENOM prenom of contact.
     * @param string|null $NOM_FAMILLE nom of contact.
     * @param string|null $SMS N° téléphonne international of contact.
     * @param string|null $CIVILITE CIVILITE of contact .
     * @param string|null $NAISSANCE birth date of contact.
     * @param string|null $ADRESSE physical adress of contact.
     * @param string|null $CODE_POSTAL postal code of contact.
     * @param string|null $VILLE city of contact.
     * @param string|null $PAYS country of contact.
     * @param string|null $NATURE role of contact.
     */
    public function addContactNewslettreToSendInBlue($EMAIL,$PRENOM=null,$NOM_FAMILLE=null,$SMS=null,$CIVILITE=null,$NAISSANCE=null,$ADRESSE=null,$CODE_POSTAL=null,$VILLE=null,$PAYS=null,$NATURE=null){
      set_time_limit(3000);
      
      if( strpos($SMS, '+') == -1|| strpos($SMS, '(') != false){
        $SMS=$this->getFormatFrenchPhoneNumber($SMS,true);
      }
      if ($SMS == "" )$SMS=null;

            // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->MY_KEY);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');

        $apiInstance = new ContactsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );
        $idlist=59;
        $createContact = new CreateContact(['email'=>$EMAIL ,
         'attributes'=>[
              'PRENOM'=>$PRENOM,
              'NOM'=>$NOM_FAMILLE,
              'SMS'=>str_replace(' ','',$SMS),
              'CIVILITE'=>$CIVILITE,
              'DATE_NAISSANCE'=>$NAISSANCE!=null?$NAISSANCE->format('Y-m-d'):$NAISSANCE,
              'ADRESSE'=>$ADRESSE,
              'CODE_POSTAL'=>$CODE_POSTAL,
              'VILLE'=>$VILLE,
              'PAYS'=>$PAYS,
          ],
        'listIds' => array($idlist) ,
        ]); // \SendinBlue\Client\Model\CreateContact | Values to create a contact
        
        $result = $apiInstance->getContactInfo($EMAIL);
        if($result!=null){
          if (!in_array($idlist, $result['listIds']))
          {
            $this->addContactToList($EMAIL, 59);
            return true;           
          }
        }else{
          $result = $apiInstance->createContact($createContact);
          return true;
        }
  }
            
    function getFormatFrenchPhoneNumber($phoneNumber, $international = false){
      //Supprimer tous les caractères qui ne sont pas des chiffres
      $phoneNumber = preg_replace('/[^0-9]+/', '', $phoneNumber);
      //On commence par traiter les cas des numéros en france
      $returnValue = preg_match('#^(33|0033)[0-9]{9}$#', $phoneNumber);
      $value = preg_match('#^(06)[0-9]{8}$#', $phoneNumber);
      $valueFR = preg_match('#^(073|074|075|076|077|078|079)[0-9]{7}$#', $phoneNumber);
      $returnValueBelge = preg_match('/^((32|0032)\s?|0)4(60|[56789]\d)(\s?\d{2}){3}$/', $phoneNumber);
      $returnValueUK = preg_match('#^(44|0044)[0-9]{10}$#', $phoneNumber);
      $valueUK = preg_match('#^(07|7)[0-9]{9}$#', $phoneNumber);
      $returnValueES = preg_match('#^(34|0034)[0-9]{9}$#', $phoneNumber);
      $valueES = preg_match('#^(6)[0-9]{8}$#', $phoneNumber);
      $returnValueRU = preg_match('#^(7|007)[0-9]{10}$#', $phoneNumber);
      $valueRU = preg_match('#^(4|8|9)[0-9]{9}$#', $phoneNumber);
      $returnValueLUX = preg_match('#^(352|00352)[0-9]{9}$#', $phoneNumber);
      $returnValueAL = preg_match('#^(49|0049)[0-9]{11}$#', $phoneNumber);
      $valueAL = preg_match('#^(15|16|17|015|016|017)[0-9]{9}$#', $phoneNumber);
      $returnValuePB = preg_match('#^(31|0031)[0-9]{9}$#', $phoneNumber);
      $valuePAB = preg_match('#^(03|3|01|1|04|4|05|5)[0-9]{8}$#', $phoneNumber);
      $valuePB = preg_match('#^(071|71|070|70|072|72)[0-9]{7}$#', $phoneNumber);
      $returnValueSUI = preg_match('#^(41|0041)[0-9]{9}$#', $phoneNumber);
                  $returnValueSUED = preg_match('#^(46|0046)[0-9]{9}$#', $phoneNumber);
                  $returnValueDANEM = preg_match('#^(45|0045)[0-9]{8}$#', $phoneNumber);
      if(($returnValue == 1) || ($value == 1) || ($valueFR == 1)){
        //On l'ecrit sous la forme +33(9chiffres)
        $phoneNumber = substr($phoneNumber, -9);
        $motif = $international ? '+33\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif ($returnValueBelge == 1) {
        //On traite les cas des numéro en belgique
        $phoneNumber = substr($phoneNumber, -9);
        $motif = $international ? '+32\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif (($returnValueUK == 1) || ($valueUK == 1)) {
        //On traite les cas des numéro en UK
        $phoneNumber = substr($phoneNumber, -10);
        $motif = $international ? '+44\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif (($returnValueES == 1) || ($valueES == 1)) {
        //On traite les cas des numéro en espagne
        $phoneNumber = substr($phoneNumber, -9);
        $motif = $international ? '+34\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif (($returnValueRU == 1) || ($valueRU == 1)) {
        //On traite les cas des numéro en russie
        $phoneNumber = substr($phoneNumber, -10);
        $motif = $international ? '+7\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif ($returnValueLUX == 1) {
        //On traite les cas des numéro en luxembourg
        $phoneNumber = substr($phoneNumber, -9);
        $motif = $international ? '+352\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif (($returnValueAL == 1) || ($valueAL == 1)) {
        //On traite les cas des numéro en allemagne
        $phoneNumber = substr($phoneNumber, -11);
        $motif = $international ? '+49\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif (($returnValuePB == 1) || ($valuePAB == 1) || ($valuePB == 1)) {
        //On traite les cas des numéro en pays-bas
        $phoneNumber = substr($phoneNumber, -9);
        $motif = $international ? '+31\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif ($returnValueSUI == 1) {
        //On traite les cas des numéro en suisse
        $phoneNumber = substr($phoneNumber, -9);
        $motif = $international ? '+41\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
      }elseif ($returnValueSUED == 1){
                      //On traite les cas des numéro en suède
        $phoneNumber = substr($phoneNumber, -9);
        $motif = $international ? '+46\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
                  }elseif ($returnValueDANEM == 1) {
                    //On traite les cas des numéro en danemark
        $phoneNumber = substr($phoneNumber, -8);
        $motif = $international ? '+45\1\2\3\4\5' : '0\1\2\3\4\5';
        $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
        return $phoneNumber;
                  }else{
        $phoneNumber = '';
        return $phoneNumber;
      }
    }

}
