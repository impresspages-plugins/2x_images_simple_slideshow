<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license GNU/GPL, see ip_license.html
 */
namespace Modules\images\simple_slideshow;


if (!defined('CMS')) exit;



class System{



    function init(){
        global $site;
        global $dispatcher;

        $site->addJavascript(BASE_URL.LIBRARY_DIR.'js/jquery/jquery.js');
        $site->addJavascript(BASE_URL.PLUGIN_DIR.'images/simple_slideshow/public/jquery.cycle.all.js');
        $site->addJavascript(BASE_URL.PLUGIN_DIR.'images/simple_slideshow/public/slideshow.js', 2);
        $site->addCSS(BASE_URL.PLUGIN_DIR.'images/simple_slideshow/public/slideshow.css');
        
        $dispatcher->bind('site.generateBlock', __NAMESPACE__ .'\System::generateSlideshow');
        
    }
    
    public static function generateSlideshow (\Ip\Event $event) {
        global $parametersMod;

        $blockName = $event->getValue('blockName');
        if ($blockName == 'simpleSlideshow') {
            require_once(__DIR__.'/model.php');
            $images = Model::getSlides();
            $options = Model::getOptions();
            $data = array (
                'images' => $images,
                'width' => $parametersMod->getValue('images', 'simple_slideshow', 'options', 'image_width'),
                'height' => $parametersMod->getValue('images', 'simple_slideshow', 'options', 'image_height'),
                'options' => $options
            );
            $slideshowHtml = \Ip\View::create('view/slideshow.php', $data)->render();
           
            $event->setValue('content', $slideshowHtml );
            $event->addProcessed();
        }
    }



}