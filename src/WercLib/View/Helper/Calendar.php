<?php
namespace WercLib\View\Helper;

use WercLib\View\Helper\AbstractCalendar;

/**
 *
 *
 * Bunka kalendare
 *
 * @author Tomas
 *        
 */
class Calendar extends AbstractCalendar
{
    
    /*
     * @see AbstractCalendar::cell()
     */
    protected function cell($year, $month, $day)
    {
        if (! empty($day)) {
            if (mktime(0, 0, 0, $month, $day, $year) < mktime(0, 0, 0, date("m"), date("d"), date("Y"))) {
                $link = '<span>' . $day . '</span>';
            } else {
                $today = "";
                if (! isset($_GET["day"])) {//plni se z url query
                    if (mktime(0, 0, 0, $month, $day, $year) == mktime(0, 0, 0, Date("m"), Date("d"), Date("Y"))) {
                        $today = 'class="active-day"';
                    }
                } else {
                    if (mktime(0, 0, 0, $month, $day, $year) == mktime(0, 0, 0, $_GET['month'], $_GET["day"], $year)) {
                        $today = 'class="active-day"';
                    }
                }
                $hash = 'day=' . $day . '&month=' . $month . '&year=' . $year;
                
                $format = '<a %s href="%s">%s</a>';
                $url = '/bowling/on-line-rezervace-drah?hs=' . Coder::encode($hash);
                $link = sprintf($format, $today, $url, $day);
            }
            
            $return = '<td>' . $link . '</td>' . PHP_EOL;
        } else {
            $return = '<td></td>' . PHP_EOL;
        }
        
        return $return;
    }
}
