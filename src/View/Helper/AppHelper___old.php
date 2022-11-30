<?php
namespace Cake\View\Helper;

use Cake\View\Helper;

class AppHelper extends UrlHelper
{
    public function build($url = null, $options = false)
    {
        print_r(parent::url($url));
        exit;

        return $url;
    }

	/*function url($url = null, $full = false)
	{
        $session = $this->request->session();
        print_r(parent::url($url, $full));
        exit;
		return '/' .
        $session->read('Config.language') .
		       parent::url($url, $full);
	}*/
 
}
?>