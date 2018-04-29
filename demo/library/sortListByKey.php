<?php
/**
 * sortListByKey
 *
 * @return void
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function sortListByKey($arrList, $sortType=true, $property) {
	usort($arrList, tr_build_sorter($property));

	if (!$sortType) {
		$arrList = array_reverse($arrList);
	}

	return $arrList;
}

function build_sorter($key) {
	return function ($a, $b) use ($key) {
		return strnatcmp($a[$key], $b[$key]);
	};
}

function tr_build_sorter($key) {
	return function ($a, $b) use ($key) {
		return tr_strcmp($a[$key], $b[$key]);
	};
}

function tr_strcmp ($a , $b) {
	$lcases = array( 'a' , 'b' , 'c' , 'ç' , 'd' , 'e' , 'f' , 'g' , 'ğ' , 'h' , 'ı' , 'i' , 'j' , 'k' , 'l' , 'm' , 'n' , 'o' , 'ö' , 'p' , 'q' , 'r' , 's' , 'ş' , 't' , 'u' , 'ü' , 'w' , 'v' , 'y' , 'z' );
	$ucases = array ( 'A' , 'B' , 'C' , 'Ç' , 'D' , 'E' , 'F' , 'G' , 'Ğ' , 'H' , 'I' , 'İ' , 'J' , 'K' , 'L' , 'M' , 'N' , 'O' , 'Ö' , 'P' , 'Q' , 'R' , 'S' , 'Ş' , 'T' , 'U' , 'Ü' , 'W' , 'V' , 'Y' , 'Z' );
	$am = mb_strlen ( $a , 'UTF-8' );
	$bm = mb_strlen ( $b , 'UTF-8' );
	$maxlen = $am > $bm ? $bm : $am;
	for ( $ai = 0; $ai < $maxlen; $ai++ ) {
		$aa = mb_substr ( $a , $ai , 1 , 'UTF-8' );
		$ba = mb_substr ( $b , $ai , 1 , 'UTF-8' );
		if ( $aa != $ba ) {
			$apos = in_array ( $aa , $lcases ) ? array_search ( $aa , $lcases ) : array_search ( $aa , $ucases );
			$bpos = in_array ( $ba , $lcases ) ? array_search ( $ba , $lcases ) : array_search ( $ba , $ucases );
			if ( $apos !== $bpos ) {
				return $apos > $bpos ? 1 : -1;
			}
		}
	}
	return 0;
}
?>