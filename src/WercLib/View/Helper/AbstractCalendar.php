<?php
namespace WercLib\View\Helper;

/**
 * Kalendar skeleton
 *
 * @author Tomas
 *        
 */
abstract class AbstractCalendar
{

    public $month;

    public $year;

    public $lang = 'cs';

    function __construct($month = null, $year = null)
    {
        if (is_null($month)) {
            $this->month = (int) date('n');
            $this->year = (int) date('y');
        } else {
            $this->month = (int) $month;
            $this->year = (int) $year;
        }
    }

    /**
     *
     * @param string $lang            
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * Pocet dnu v mesici
     *
     * @return number
     */
    public function daysInMonth()
    {
        return cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
    }

    /**
     *
     * @param int $month            
     * @return string
     */
    public function getMonthName($month)
    {
        $cs = array(
            1 => 'Leden',
            'Únor',
            'Březen',
            'Duben',
            'Květen',
            'Červen',
            'Červenec',
            'Srpen',
            'Září',
            'Říjen',
            'Listopad',
            'Prosinec'
        );
        
        switch ($this->lang) {
            default:
                $translations = $cs;
        }
        
        return $translations[$month];
    }

    /**
     *
     * @param int $day            
     * @return string
     */
    public function getDayName($day)
    {
        $cs = array(
            1 => "Po",
            "Út",
            "St",
            "Čt",
            "Pá",
            "So",
            "Ne"
        );
        
        switch ($this->lang) {
            default:
                $translations = $cs;
        }
        
        return $translations[$day];
    }

    /**
     * Zacina na 1 - Pondeli ne nula
     * http://php.net/manual/en/function.date.php
     */
    public function firstDayOffset()
    {
        return date('N', mktime(0, 0, 0, $this->month, 1, $this->year));
    }

    /**
     * Matice dnu, radky tydne
     */
    public function matrixOfDays()
    {
        $daysCount = $this->daysInMonth();
        $offsetFirstDay = $this->firstDayOffset();
        
        $week = 1;
        $_array = array();
        for ($i = 1; $i < $daysCount + $offsetFirstDay; $i ++) {
            
            if ($i < $offsetFirstDay) {
                $_array[$week][] = null;
            } else {
                $_array[$week][] = $i - $offsetFirstDay + 1;
            }
            
            if ($i % 7 == 0) { // celocisleny zbytek po deleni
                $week ++;
            }
        }
        
        return $_array;
    }

    /**
     * Pridej obsah v bunce
     */
    abstract protected function cell($year, $month, $day);

    /**
     * Generuj html
     */
    public function show()
    {
        $table = array();
        
        $table[] = '<table class="table table-bordered calendar">';
        $table[] = '<thead><tr>';
        $table[] = '<th colspan="7">' . $this->getMonthName($this->month) . ' ' . $this->year . '</th>';
        $table[] = '</tr></thead><tbody><tr class="days">';
        for ($i = 1; $i <= 7; $i ++) {
            $table[] = '<td>' . $this->getDayName($i) . '</td>';
        }
        $table[] = '</tr>';
        
        $daysMatrix = $this->matrixOfDays();
        foreach ($daysMatrix as $i => $week) {
            $table[] = '<tr>';
            foreach ($week as $j => $day) {
                $table[] = $this->cell($this->year, $this->month, $day);
            }
            $table[] = '</tr>';
        }
        $table[] = '<tbody></table>' . PHP_EOL;
        
        return implode('', $table);
    }
}
