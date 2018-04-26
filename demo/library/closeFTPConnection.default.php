<?php
/**
 * closeFTPConnection - closes FTP connection
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

function closeFTPConnection() {
    global $gftpConnection;

    if ($gftpConnection != NULL) {
        // close the FTP stream
        ftp_close($gftpConnection);
        unset($gftpConnection);
    } else {
        return false;
    } // if ($gftpConnection != NULL) {
}
?>