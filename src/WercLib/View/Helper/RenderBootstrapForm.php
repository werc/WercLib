<?php
namespace WercLib\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\Element;

/**
 * Bootstrap form 3.0
 */
class RenderBootstrapForm extends AbstractHelper
{

    public function __invoke($form)
    {
        $form->prepare();
        $output = $this->view->form()->openTag($form) . PHP_EOL;
        
        $elements = $form->getElements();
        foreach ($elements as $element) {
            $options = $element->getOptions();
            if ($element instanceof Element\Button OR $element instanceof Element\Hidden) {
                $output .= $this->view->formElement($element) . PHP_EOL;
            } elseif ($element instanceof Element\Checkbox) {
                $output .= '<div class="checkbox">';
                $output .= $this->view->formRow($element);
                $output .= '</div>' . PHP_EOL;
            } else {
                $output .= '<div class="form-group">' . $this->view->formLabel($element) . PHP_EOL;
                $output .= $this->view->formElement($element);
                
                if (array_key_exists('description', $options)) {
                    $output .= '<p class="text-muted">' . $options['description'] . '</p>';
                }
                $output .= $this->view->formElementErrors($element);
                $output .= '</div>' . PHP_EOL;
            }
        }
        $output .= $this->view->form()->closeTag($form) . PHP_EOL;
        
        return $output;
    }
}
