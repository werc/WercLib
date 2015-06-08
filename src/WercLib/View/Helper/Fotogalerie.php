<?php
namespace WercLib\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 *
 * @author Tomas
 *        
 */
class Fotogalerie extends AbstractHelper
{

    const SEPARATOR = '/';

    function __invoke($result)
    {
        $output = '';
        
        if (! empty($result)) {
            $this->getView()->headLink()
                            ->appendStylesheet($this->getView()->basePath() . '/components/lightbox/css/lightbox.css');
            $this->getView()->inlineScript()
                            ->appendFile($this->getView()->basePath() . '/components/lightbox/js/lightbox-2.6.min.js');
            
            $output = '<h4><i class="glyphicon glyphicon-th-large"></i> ' . $this->getView()->translate('Fotogalerie') . '</h4><div class="foto-container">';
            $escaper = new \Zend\Escaper\Escaper('utf-8');
            foreach ($result as $foto) {
                $filePathLarge = self::SEPARATOR . $foto->dir . self::SEPARATOR . 'large' . self::SEPARATOR . $foto->path . self::SEPARATOR . $foto->foto;
                $filePathThumb = self::SEPARATOR . $foto->dir . self::SEPARATOR . 'th' . self::SEPARATOR . $foto->path . self::SEPARATOR . $foto->foto;
                $fotoPopis = '';
                if (! empty($foto->popis)) {
                    $fotoPopis = $escaper->escapeHtmlAttr($foto->popis);
                }
                $output .= '<a href="' . $this->getView()->basePath() . '/fotosklad' . $filePathLarge . '" data-lightbox="roadtrip"
                           title="' . $fotoPopis . '">' . '<img src="' . $this->getView()->basePath() . '/fotosklad' . $filePathThumb . '"
                           alt="' . $fotoPopis . '"></a>';
            }
            $output .= '</div>';
        }
        
        return $output;
    }
}