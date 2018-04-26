<?php
/**
 * resetUserPassword - resets user password specified with strEmailAddress
 *
 * @param objUser [User][in]: User object
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

function resetUserPassword($objUser) {
	$arrCities = array("shanghai",
			"istanbul",
			"karachi",
			"mumbai",
			"beijing",
			"moscow",
			"saopaulo",
			"tianjin",
			"guangzhou",
			"delhi",
			"seoul",
			"shenzhen",
			"jakarta",
			"tokyo",
			"mexicocity",
			"kinshasa",
			"tehran",
			"bangalore",
			"dongguan",
			"newyorkcity",
			"lagos",
			"london",
			"lima",
			"bogota",
			"hochiminhcity",
			"hongkong",
			"bangkok",
			"dhaka",
			"hyderabad",
			"cairo",
			"hanoi",
			"wuhan",
			"riodejaneiro",
			"lahore",
			"ahmedabad",
			"baghdad",
			"riyadh",
			"singapore",
			"santiago",
			"saintpetersburg",
			"chennai",
			"chongqing",
			"kolkata",
			"surat",
			"yangon",
			"ankara",
			"alexandria",
			"shenyang",
			"suzhou",
			"newtaipei",
			"johannesburg",
			"losangeles",
			"yokohama",
			"abidjan",
			"busan",
			"berlin",
			"capetown",
			"durban",
			"jeddah",
			"pyongyang",
			"madrid",
			"nairobi",
			"pune",
			"jaipur",
			"casablanca");

	$strNewPassword = $arrCities[rand(0, 64)] . date('si');
	$objUser->strPasswordProperty = $strNewPassword;
	$objUser->update();

	includeLibrary('spritpanel/sendResetUserPasswordEmail');
	sendResetUserPasswordEmail($objUser, $strNewPassword);
}
?>