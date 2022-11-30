<?php
namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\Mailer\Email;
use Mustache_Engine;
use Cake\ORM\TableRegistry;
use libphonenumber\PhoneNumberUtil;
use SoapClient;

class EmailListener implements EventListenerInterface
{
    private $frPhoneLangs=[
            //france
            '#^(33|0033)[0-9]{9}$#',
            '#^(06)[0-9]{8}$#',
            '#^(073|074|075|076|077|078|079)[0-9]{7}$#',
            //belgique
            '/^((32|0032)\s?|0)4(60|[56789]\d)(\s?\d{2}){3}$/',
            //suisse
            '#^(41|0041)[0-9]{9}$#',
            //canada
            '#^(1|001)[0-9]{10}$#',
            //algeria
            '#^(213)[0-9]{9,10}$#',
            //egypt
            '#^(20)[0-9]{9,10,11}|^(0)[0-9]{9,10,11}$#',
            //libye
            '#^(218)[0-9]{10}$#',
            //maroc
            '#^(212)[0-9]{9,10}$#',
            //tunisie
            '#^(216)[0-9]{8}|^(5|4|9|2)[0-9]{7}$#',
            //sudan
            '#^(249)[0-9]{10}$#',
            //mauritanie
            '#^(222)[0-9]{8}$#'
        ];
    private $frPays=[
        33,687,355,376,54,374,43,32,229,387,359,
        226,257,855,237,1,238,236,357,269,242,82,
        506,255,385,253,1767,20,971,372,241,220,995,233,30,224,245,
        509,36,353,383,856,371,961,370,352,389,261,223,356,212,230,222,
        52,373,377,382,258,227,48,974,420,40,250,
        239,221,381,248,421,386,41,235,66,228,216,380,598,678,84,
    ];
    
    public function implementedEvents()
    {
        return [
            'Email.send' => 'sendMail',
            'Email.sendSms' => 'sendSms',
        ];
    }

    public function sendMail($event,$from,$to,$textEmail,$data,$template,$viewVars,$noReply,$attachments=null,$additionalData=null,$langue=null)
    {
        $m = new Mustache_Engine;
        if(is_string($textEmail))
        {
            $Modelmailsysteme=TableRegistry::get('Modelmailsysteme');
            $textEmail=$Modelmailsysteme->find('all',["conditions"=>['titre'=>$textEmail]])->first();
        }
        $text = $m->render($textEmail->txtmail, $data);
        $sujet = $m->render($textEmail->sujet, $data);
        if(is_string($to))
        {
            $toEmail=$to;
        }
        else 
        {
            $toEmail=$to['email'];

            if(trim($textEmail->txtmailEn)!='' && trim($textEmail->sujetEn)!='' && $to['portable']!=null && $to['portable']!='' && $this->getLangFromPhoneNumber($to['portable'])=='EN')
            {
                $text = $m->render($textEmail->txtmailEn, $data);
                $sujet = $m->render($textEmail->sujetEn, $data);
            }            
        }
        if($langue == "EN"){
            $text = $m->render($textEmail->txtmailEn, $data);
            $sujet = $m->render($textEmail->sujetEn, $data);
        }
        $email = new Email('production');
        $email->template($template, 'default')
                                            ->emailFormat('html')
                                            ->to(trim($toEmail))
                                            ->from($from);
        if($additionalData!=null){
            $vars=[$viewVars => $text];
            foreach ($additionalData as $key=>$data)
            {
                $vars[$key]=$data;
            }
            $email->subject($sujet)
            ->viewVars($vars);
        }else
        {
            $email->subject($sujet)
            ->viewVars([$viewVars => $text]);
        }
        if($attachments!=null){$email->attachments($attachments);}
        if($noReply==true){$email->replyTo('noreply@alpissime.com');}
        $email->send();
    }

    public function sendSms($event,$from,$to,$textSms,$data,$langue=null)
    {
        $m = new Mustache_Engine;
        if(is_string($textSms))
        {
            $Modelsmsysteme=TableRegistry::get('Modelsmsysteme');
            $textSms=$Modelsmsysteme->find('all',["conditions"=>['titre'=>$textSms]])->first();
        }
        $text = $m->render($textSms->txtsms, $data);
        
        if(is_string($to))
        {
            $toSms=$to;
        }
        else 
        {
            $toSms=$to['portable'];
        }

        if(trim($textSms->txtsmsEn)!='' && trim($textSms->sujetEn)!='' && $toSms!=null && $toSms!='' && $this->getLangFromPhoneNumber($toSms)=='EN')
        {
            $text = $m->render($textSms->txtsmsEn, $data);
        }            
        
        if($langue == "EN"){
            $text = $m->render($textSms->txtsmsEn, $data);
        }
        
        /* envoie sms vers propriétaire */
        $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.61.wsdl"); 	//login
        $session = $soap->login("dt29400-ovh", 'q}XcJ_"jLw',"fr", false);
        $smstext = mb_substr($text, 0, 157, 'utf8')."...";
        $soap->telephonySmsSend($session, "sms-dt29400-1", $from, $toSms, $smstext, "2880", "1", "0", "3", "1", "", true);
        $soap->logout($session);

    }
    
    private function getLangFromPhoneNumber($phoneNumber){
  	if($phoneNumber[0]!='+')
        {
            //Supprimer tous les caractères qui ne sont pas des chiffres
            $phoneNumber = preg_replace('/[^0-9]+/', '', $phoneNumber);

            foreach ($this->frPhoneLangs as $frLang) {
                if(preg_match($frLang,$phoneNumber)	==1)
                    return 'FR';
            }
            return 'EN';
        }
        else
        {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse($phoneNumber);
            $isValid = $phoneUtil->isValidNumber($numberProto);
            if($isValid){
                try{
                    $result=$numberProto->getCountryCode();
                } catch (Exception $e){}
                if(in_array($result,$this->frPays))
                    return 'FR';
                else
                    return 'EN';
            }
            else{
                return 'EN';
            }
        }
        return 'EN';
    }
    
}