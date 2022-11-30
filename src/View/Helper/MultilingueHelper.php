<?php
namespace App\View\Helper;

use Cake\View\Helper\UrlHelper;
use Cake\Routing\Router;

class MultilingueHelper extends UrlHelper
{
	public function build($url = null, $options = false)
    {
		$defaults = [
			'fullBase' => false,
			'escape' => true,
		];
		if (!is_array($options)) {
			$options = ['fullBase' => $options];
		}
		$options += $defaults;

		$url = Router::url($url, $options['fullBase']);
		if ($options['escape']) {
			$url = h($url);
		}

		// $session = $this->request->session();
		// return '/' .
        // 	$session->read('Config.language') .
		// 	$url;
        

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
 
	/*function link($title, $url = null, $htmlAttributes = array(), $confirmMessage = false, $escapeTitle = true)
	{
		return parent::link($title, $url, $htmlAttributes, $confirmMessage, $escapeTitle);
	}*/
}
?>