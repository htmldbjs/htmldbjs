<?php
/**
 * openFTPConnection - opens an FTP connection
 *
 * @note Please after opening all FTP connection call,
 * closeFTPConnection to close the current connection.
 *
 * @return This function returns TRUE, if connection
 * is successfully established, returns FALSE, otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function openFTPConnection() {

    if (!file_exists(CNFDIR . '/FTP.php')) {
        return false;
    } // if (!file_exists(CNFDIR . '/FTP.php')) {
    
    global $gftpConnection;
    global $_SPRIT;

    if ($_SPRIT['FTP_SECURE_ENABLED']) {
        $gftpConnection = ftp_ssl_connect(
                $_SPRIT['FTP_HOST_NAME'],
                $_SPRIT['FTP_PORT']);
    } else {
        $gftpConnection = ftp_connect(
                $_SPRIT['FTP_HOST_NAME'],
                $_SPRIT['FTP_PORT']);
    } // if (FTP_PRIMARY_SECURE_ENABLED) {
    
    $success = ftp_login($gftpConnection,
            $_SPRIT['FTP_USER_NAME'],
            $_SPRIT['FTP_PASSWORD']);

    if ((!$gftpConnection) || (!$success)) {
        return false;
    } // if ((!$gftpConnection) || (!$success)) {

    return true;

}
?>