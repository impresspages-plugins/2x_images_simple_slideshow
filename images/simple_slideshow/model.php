<?php
/**
 * @package	ImpressPages
 * @copyright	Copyright (C) 2011 ImpressPages LTD.
 * @license	GNU/GPL, see ip_license.html
 */

namespace Modules\images\simple_slideshow;

if (!defined('CMS')) exit;

/**
 * 
 * Communicatin with database
 *
 */

class Model {

    /**
     * 
     * return an array of available images in the database
     * @throws Exception
     */
    public static function getSlides() {
        $sql = "
        SELECT * FROM ".DB_PREF."m_images_simple_slideshow WHERE `visibility` = 1 ORDER BY `row_number`
        ";

        $rs = mysql_query($sql);

        if (!$rs) {
            throw new \Exception('Slideshow plugin is not installed '.$sql.' '.mysql_error());
        }

        $answer = array();

        while($lock = mysql_fetch_assoc($rs)) {
            $answer[] = $lock;
        }
        return $answer;
    }


    public static function getOptions() {
        global $parametersMod;
        $answer = array();

        $optionsStr = $parametersMod->getValue('images', 'simple_slideshow', 'options', 'playback_options');
        $optionLines = preg_split ('/$\R?^/m', $optionsStr);
        foreach($optionLines as $optionLine) {
            $parts = explode(':', $optionLine, 2);
            if (count($parts) != 2) {
                continue;
            }
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            $firstChar = substr($parts[1], 0, 1);
            if ($firstChar != '\'' && $firstChar != '"'){
                $value = (int)$value;
            } else {
                $value = mb_substr($value, 1, -1);
            }
            if ($key == '' || $value == '') {
                continue;
            }
            $answer[$key] = $value;
        }
        return $answer;
    }

    
    
}
