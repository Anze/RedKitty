<?php
//
//  Helper.php
//  redkitty
//
//  Created by Anze on 2017-06-21.
//  Copyright 2017 0804Team. All rights reserved.
//  Licensed under MIT
//

class Helper {

	public static function plural($number=0, $f1=null, $f2=null, $f5=null) {
		$number = abs($number) % 100;
		$n1 = $number % 10;
		if (($number>10) && ($number<20))
			return isset($f5) ? $f5 : $f2;
		elseif (($n1>1) && ($n1<5))
			return $f2;
		elseif ($n1==1)
			return $f1;
		return isset($f5) ? $f5 : $f2;
	}

	public static function pages($params, $url) {
		if (!isset($params['total'])) return '';
		if (!isset($params['current']) || !$params['current'] || $params['current']<1) $params['current'] = 1;
		$retval = "";
		for($i=1; $i<=$params['total']; $i++) {
			if ($i == $params['current']) {
				$retval .= '<span class="paginate_active">'.$i.'</span>'."\n";
			}
			else {
				if (($params['total']>3) && ($i>1)) {
					if (($params['current']>3) && ($i<$params['current']-2)) {
						$i = $params['current']-2;
						$retval .= ' ... ';
					}
					elseif ($i>$params['current']+2 && $params['current']<($params['total']-3)) {
						$retval .= ' ... <a href="'.$url.'?page='.$params['total'].'" class="paginate_button">'.$params['total'].'</a>'."\n";
						break;
					}
				}
				$retval .= ' <a href="'.$url.'?page='.$i.'" class="paginate_button">'.$i.'</a>'."\n";
			}
		}
		return str_replace('//', '/', $retval);
	}

}
