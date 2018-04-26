<?php
/**
* Menu Layer Items
*/

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['SPRITPANEL_MENU'] = array();


$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'unitclass',
		'index' => 0,
		'name' => 'Unit',
		'URL' => 'unitclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'Unit',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'crewclass',
		'index' => 1,
		'name' => 'Crew',
		'URL' => 'crewclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'Crew',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'userclass',
		'index' => 2,
		'name' => 'User',
		'URL' => 'userclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'User',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'companyclass',
		'index' => 3,
		'name' => 'Company',
		'URL' => 'companyclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'Company',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'applicationtaskdirectoryclass',
		'index' => 4,
		'name' => 'ApplicationTaskDirectory',
		'URL' => 'applicationtaskdirectoryclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'ApplicationTaskDirectory',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'auditclass',
		'index' => 5,
		'name' => 'Audit',
		'URL' => 'auditclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'Audit',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'audittypeclass',
		'index' => 6,
		'name' => 'AuditType',
		'URL' => 'audittypeclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'AuditType',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'auditstateclass',
		'index' => 7,
		'name' => 'AuditState',
		'URL' => 'auditstateclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'AuditState',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'auditstepcategoryclass',
		'index' => 8,
		'name' => 'AuditStepCategory',
		'URL' => 'auditstepcategoryclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'AuditStepCategory',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'auditsteptypeclass',
		'index' => 9,
		'name' => 'AuditStepType',
		'URL' => 'auditsteptypeclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'AuditStepType',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'auditstepclass',
		'index' => 10,
		'name' => 'AuditStep',
		'URL' => 'auditstepclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'AuditStep',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'auditstepdirectoryclass',
		'index' => 11,
		'name' => 'AuditStepDirectory',
		'URL' => 'auditstepdirectoryclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'AuditStepDirectory',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'applicationclass',
		'index' => 12,
		'name' => 'Application',
		'URL' => 'applicationclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'Application',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'applicationtaskclass',
		'index' => 13,
		'name' => 'ApplicationTask',
		'URL' => 'applicationtaskclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'ApplicationTask',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'applicationtaskcategoryclass',
		'index' => 14,
		'name' => 'ApplicationTaskCategory',
		'URL' => 'applicationtaskcategoryclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'ApplicationTaskCategory',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'applicationtaskstateclass',
		'index' => 15,
		'name' => 'ApplicationTaskState',
		'URL' => 'applicationtaskstateclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'ApplicationTaskState',
		'visible' => 1
);
$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'applicationsubtaskclass',
		'index' => 16,
		'name' => 'ApplicationSubTask',
		'URL' => 'applicationsubtaskclass',
		'editable' => 1,
		'parentId' => 'lists',
		'className' => 'ApplicationSubTask',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'home',
		'index' => 1,
		'name' => 'Home',
		'URL' => 'home',
		'editable' => 0,
		'parentId' => '',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'my_profile',
		'index' => 2,
		'name' => 'My Profile',
		'URL' => 'my_profile',
		'editable' => 0,
		'parentId' => '',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'lists',
		'index' => 4,
		'name' => 'Lists',
		'URL' => '',
		'editable' => 1,
		'parentId' => '',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'media',
		'index' => 5,
		'name' => 'Media',
		'URL' => 'media',
		'editable' => 1,
		'parentId' => '',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'configuration',
		'index' => 6,
		'name' => 'Configuration',
		'URL' => '',
		'editable' => 1,
		'parentId' => '',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'server_information',
		'index' => 1,
		'name' => 'Server Information',
		'URL' => 'server_information',
		'editable' => 1,
		'parentId' => 'configuration',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'general_settings',
		'index' => 2,
		'name' => 'General Settings',
		'URL' => 'general_settings',
		'editable' => 1,
		'parentId' => 'configuration',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'menu_configuration',
		'index' => 3,
		'name' => 'Menu Configuration',
		'URL' => 'menu_configuration',
		'editable' => 1,
		'parentId' => 'configuration',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'languages',
		'index' => 4,
		'name' => 'Languages',
		'URL' => 'languages',
		'editable' => 1,
		'parentId' => 'configuration',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'users',
		'index' => 5,
		'name' => 'Users',
		'URL' => 'users',
		'editable' => 1,
		'parentId' => 'configuration',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'ftp_server',
		'index' => 6,
		'name' => 'FTP Server',
		'URL' => 'ftp_server',
		'editable' => 1,
		'parentId' => 'configuration',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'database_server',
		'index' => 7,
		'name' => 'Database Server',
		'URL' => 'database_server',
		'editable' => 1,
		'parentId' => 'configuration',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'email_server',
		'index' => 8,
		'name' => 'Email Server',
		'URL' => 'email_server',
		'editable' => 1,
		'parentId' => 'configuration',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'logout',
		'index' => 7,
		'name' => 'Logout',
		'URL' => 'logout',
		'editable' => 0,
		'parentId' => '',
		'visible' => 1
);

?>