<?php
namespace WercLib\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * View Helper
 */
class ShareLink extends AbstractHelper
{

    const SITE = 'http://';

    public $url;

    public function __invoke($media, $params)
    {
        if (array_key_exists('url', $params)) {
            $this->url = self::SITE . $params['url'];
        }
        
        switch ($media) {
            case 'email':
                return $this->email($params);
                break;
            case 'facebook':
                return $this->facebook($params);
                break;
            case 'google':
                return $this->google($params);
                break;
            case 'twitter':
                return $this->twitter($params);
                break;
        }
        return null;
    }

    public function email($params)
    {
        return 'mailto:?subject=' . $params['title'] . '&amp;body=' . $params['body'];
    }

    public function twitter($params)
    {
        return 'http://twitter.com/share?text=' . urlencode($params['title']) . '&amp;url=' . $this->url;
    }

    public function google($params)
    {
        $link = 'https://plus.google.com/share?url=' . $this->url;
        
        return $link;
    }

    public function facebook($params)
    {
        return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($this->url);
    }
}
