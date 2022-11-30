<?php
namespace App\View\Helper;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class TelephoneHelper extends Helper
{
    public function toStr($tel)
    {
        if (strlen($tel)==10) {
            $result = substr($tel,0,2)."-".
                      substr($tel,2,2)."-".
                      substr($tel,4,2)."-".
                      substr($tel,6,2)."-".
                      substr($tel,8,2);
        }
        else
            $result = $tel;
        return $result;
    }

    public function toInternal($tel)
    {
        $result="";
        if ($tel!="0")
            for($i=0;$i<strlen($tel);$i++)
            {
                $chr = substr($tel,$i,1);
                switch($chr) {
                    case '0': case '1': case '2': case '3': case '4':
                    case '5': case '6': case '7': case '8': case '9':
                        $result.=$chr;
                        break;
                }
            }
        return $result;
    }

	public function toFind($tel)
	{
        $tel=str_replace(" ","",$tel);
        $tel=str_replace("-","",$tel);
        $tel=str_replace(".","",$tel);
        $tel=str_replace("/","",$tel);
		$result = "";
		for($i=0;$i<strlen($tel);$i++) {
			if ($i && !($i%2)) $result.="%";
			$result.= substr($tel,$i,1);
		}
		return $result;
	}
}
?>
