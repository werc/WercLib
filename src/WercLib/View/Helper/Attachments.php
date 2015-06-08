<?php
namespace WercLib\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 *
 * @author Tomas
 *        
 */
class Attachments extends AbstractHelper
{

    const SEPARATOR = '/';

    function __invoke ($resultSet)
    {
        $output = '';
        
        if (! empty($resultSet)) {
            $output = PHP_EOL . '<h4><i class="glyphicon glyphicon-download"></i> ' .
                     $this->getView()->translate('Přílohy ke stažení') .
                     '</h4><ul class="attachments-container">' . PHP_EOL;
            $format = '<li>%s <a href="%s" target="_blank" title="%s">%s</a></li>' .
                     PHP_EOL;
            
            foreach ($resultSet as $row) {
                $url = $this->getView()->basePath() . '/download/' . $row->path .
                         self::SEPARATOR . $row->file;
                $note = $this->getView()->escapeHtml($row->note_cs);
                $output .= sprintf($format, $note, $url, $note, $row->file);
            }
            
            $output .= '</ul>';
        }
        
        return $output;
    }
}
