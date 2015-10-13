<?php

namespace App\View\Helper;

use Cake\View\Helper;

class TimeHelper extends Helper
{
    function elapsed($time)
    {
      $etime = time() - strtotime($time);

      if ($etime < 1)
      {
          return '0 seconden';
      }

      $a = array( 365 * 24 * 60 * 60  =>  'jaar',
                   30 * 24 * 60 * 60  =>  'maand',
                        24 * 60 * 60  =>  'dag',
                             60 * 60  =>  'uur',
                                  60  =>  'minuut',
                                   1  =>  'seconde'
                  );
      $a_plural = array( 'jaar'   => 'jaren',
                         'maand'  => 'maanden',
                         'dag'    => 'dagen',
                         'uur'   => 'uren',
                         'minuut' => 'minuten',
                         'seconde' => 'seconden'
                  );

      foreach ($a as $secs => $str)
      {
          $d = $etime / $secs;
          if ($d >= 1)
          {
              $r = round($d);
              return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' geleden';
          }
      }
    }
}