<?php
/**
 * getCrewTypeText - 
 * @return type text.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getCrewTypeText($type) {
		$typeDisplayText = '';

		switch ($type) {
			case 1:
				$typeDisplayText = 'Sponsor';
				break;
			case 2:
				$typeDisplayText = 'Koordinatör';
				break;
			case 3:
				$typeDisplayText = 'İSG Temsilcisi';
				break;
			case 4:
				$typeDisplayText = 'İK Temsilcisi';
				break;
			case 5:
				$typeDisplayText = 'Planlama Temsilcisi';
				break;
			case 6:
				$typeDisplayText = 'Bakım Temsilcisi';
				break;
			case 7:
				$typeDisplayText = 'Kalite Temsilcisi';
				break;
			case 8:
				$typeDisplayText = 'Yayılım Şampiyonu';
				break;
			case 9:
				$typeDisplayText = 'Süreç Sahibi';
				break;
			case 10:
				$typeDisplayText = 'Şampiyon';
				break;
			case 11:
				$typeDisplayText = 'Rehber';
				break;
			case 12:
				$typeDisplayText = '1. Alan Lideri';
				break;
			case 13:
				$typeDisplayText = '2. Alan Lideri';
				break;
			case 14:
				$typeDisplayText = '3. Alan Lideri';
				break;
			case 15:
				$typeDisplayText = 'Ekip Üyesi';
				break;
		}

		return $typeDisplayText;
	}
?>