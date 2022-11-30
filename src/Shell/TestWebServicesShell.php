<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Http\Client;
use Cake\Mailer\Email;
use Cake\Utility\Text;
use Cake\Log\Log;

class TestWebServicesShell extends Shell
{
    private $http;
    private $to;
    private $from;
    /*
     ** get : url, method=get, headers=array
     ** post: url, method=post,optional data=array,optional  headers=array
     */
    private $urls=[
        ['url'=>'http://www.alpissime.com/api/get_partners','method'=>'get'],
        ['url'=>'http://www.alpissime.com/api/get_partners','method'=>'post'],
        ['url'=>'http://www.alpissime.com/blog/services_alpissime/service/get_versions.php', 'method'=>'get'],
        ['url'=>'http://www.alpissime.com/blog/services_alpissime/service/get_podcasts.php', 'method'=>'get']
        // http://www.alpissime.com/blog/feed/
    ];
    public function initialize()
    {
        parent::initialize();
        $this->to='maroua.c@ite.digital';
        $this->from='administration@alpissime.com';
        $this->http = new Client();
    }
    
    public function main()
    {
        Log::write('info', 'START testUrls FUNCTION');
        $this->testUrls();
        Log::write('info', 'END testUrls FUNCTION');
    }
    
    private function testUrls()
    {
        foreach($this->urls as $url){
            switch ($url['method']) {
            case 'get':
                $this->testGet($url);
                break;
            case 'post':
                $this->testPost($url);
                break;
            default:
                $this->unknownMethod($url);
                break;
            }
        }
    }
    
    private function testGet($url)
    {
        if(isset($url['headers']))
            $response = $this->http->get($url['url'],[],['headers'=>$url['headers']]);
        else
            $response = $this->http->get($url['url']);
        $this->afterResponse($response,$url);
    }
    
    private function testPost($url)
    {
        $data=[];
        if(isset($url['data'])) $data=$url['data'];
        if(isset($url['headers']))
            $response = $this->http->post($url['url'], json_encode($data),['type' => 'json','headers'=>$url['headers']]);
        else
            $response = $this->http->post($url['url'], json_encode($data),['type' => 'json']);
        $this->afterResponse($response,$url);
    }
    private function afterResponse($response,$url)
    {
        $responseCode=$response->getStatusCode();
        $responsePhrase=$response->getReasonPhrase();
        if($responseCode!=200){
            $text= Text::insert(
                        '<h1>Erreur Dans Web Service Alpissime</h1>'.
                        'code = :code <br>'.
                        'phrase = :phrase <br>'.
                        'url = :url <br>'.
                        'Méthode = :method'
                        ,
                        ['code' => $responseCode, 'url' => $url['url'], 'phrase'=>$responsePhrase,'method'=>$url['method']]
                    );
            $email = new Email('default');
            $email->from([$this->from => 'TestWebServicesShell'])
                ->emailFormat('html')
                ->to($this->to)
                ->subject('webservice Has Error')
                ->send($text);
        }
    }
    
    public function unknownMethod($url){
        $email = new Email('default');
        $email->from([$this->from => 'TestWebServicesShell'])
            ->emailFormat('html')
            ->to($this->to)
            ->subject('TestWebServicesShell Méthode inconnue')
            ->send('Méthode inconnue pour l\'url :'.$url['url']);
    }
}

