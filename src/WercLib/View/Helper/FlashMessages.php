<?php
namespace WercLib\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

/**
 * Sestaveni zprav z FlashMessengeru
 */
class FlashMessages extends AbstractHelper
{

    protected $flashMessenger;
 
    public function setFlashMessenger (FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    public function __invoke ($includeCurrentMessages = true)
    {
        if ($includeCurrentMessages) {
            $this->flashMessenger->clearMessages();
        }
        
        $messages = array(
            FlashMessenger::NAMESPACE_ERROR => array(), 
            FlashMessenger::NAMESPACE_SUCCESS => array(), 
            FlashMessenger::NAMESPACE_INFO => array(), 
            FlashMessenger::NAMESPACE_DEFAULT => array()
        );
        
        foreach ($messages as $ns => &$m) {
            $m = $this->flashMessenger->getMessagesFromNamespace($ns);
            if ($includeCurrentMessages) {
                $m = array_merge($m, $this->flashMessenger->getCurrentMessagesFromNamespace($ns));
                $this->flashMessenger->clearCurrentMessagesFromNamespace($ns);
            }
        }
        
        $output = '';
        foreach ($messages as $namespace => $messages) {
            if($namespace == 'error') {
                $namespace = 'danger';
            }
            if (count($messages)) {
                $output .= '<div class="alert alert-' . $namespace . ' alert-dismissable">';
                $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                foreach ($messages as $message) {
                    $output .= $message;
                }
                $output .= '</div>' . PHP_EOL;
            }
        }
        
        return $output;
    }
}
