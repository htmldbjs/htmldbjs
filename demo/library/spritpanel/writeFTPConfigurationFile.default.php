<?php
/**
 * writeFTPConfigurationFile - prepare FTP.php content
 *
 * @return file content.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
        == strtolower(basename(__FILE__))) {
    header('HTTP/1.0 404 Not Found');
    header('Status: 404 Not Found');
    die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function writeFTPConfigurationFile($arrUpdatedValues) {

    global $gftpConnection;

    $strContent = file_get_contents(SPRITPANEL_TMPDIR . '/FTPTemplate.php');
    $strFind = '';
    $strReplace = '';
    $arrKeys = array_keys($arrUpdatedValues);
    $lCountKeys = count($arrKeys);

    for ($i=0; $i < $lCountKeys; $i++) {
        $strFind = '{{' . $arrKeys[$i] . '}}';        
        $strReplace = $arrUpdatedValues[$arrKeys[$i]];
        $strContent = str_replace($strFind, $strReplace, $strContent);
    } // for ($i=0; $i < $lCountKeys; $i++) {

    $strTempFileName = (sys_get_temp_dir() . '/write.' . session_id());

    $fiCurrentMessage = fopen($strTempFileName, 'w');
    fwrite($fiCurrentMessage, $strContent);
    fclose($fiCurrentMessage);

    ftp_put($gftpConnection,
            ($arrUpdatedValues['FTP_HOME']
            . '/configuration'
            . DIRECTORY_SEPARATOR
            . 'FTP.php'),
            $strTempFileName,
            FTP_BINARY);

    // Delete created temp file
    unlink($strTempFileName);

    return true;

}
?>