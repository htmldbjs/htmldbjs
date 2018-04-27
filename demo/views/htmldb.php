<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Title</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="shortcut icon" href="assets/img/favicon.ico">
	<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
</head>
<body>
	<button type="button"
	class="htmldb-button-refresh"
	data-htmldb-table="">Refresh</button>
	<hr>
	<div class="divPanel htmldb-section" data-htmldb-table="activeCompaniesHTMLDB">
		<p data-htmldb-content="{{company_name}}"></p>
	</div>
	<hr>
	<form id="companyForm" class="htmldb-form" data-htmldb-table="activeCompaniesHTMLDB">
		<table cellspacing="2" cellpadding="5" border="1">
			<thead>
				<tr>
					<th align="right">
						<button type="button"
								class="htmldb-button-add"
								data-htmldb-form="companyForm">Add</button>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input id="input1"
						type="hidden"
						class="htmldb-field"
						data-htmldb-field="id"
						data-htmldb-value="{{id}}"
						value="">
					</td>
				</tr>
				<tr>
					<td><input id="input2"
						type="text"
						class="htmldb-field"
						data-htmldb-field="company_name"
						data-htmldb-value="{{company_name}}"
						value="">
					</td>
				</tr>
				<tr>
					<td>
						<select id="input2"
						class="htmldb-field"
						data-htmldb-field="company_type"
						data-htmldb-option-table="companyTypesHTMLDB"
						data-htmldb-option-value="{{id}}"
						data-htmldb-option-title="{{name}}"
						data-htmldb-value="{{company_type}}"></select>
					</td>
				</tr>
				<tr>
					<td>
						<button type="button"
						class="htmldb-button-save"
						data-htmldb-form="">Save</button>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<hr>
	<table id="tableActiveCompanyList" cellspacing="2" cellpadding="5" data-htmldb-table="activeCompaniesHTMLDB" border="1">
		<thead>
			<tr>
				<th align="left">ID</th>
				<th align="left">Name</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="tbodyActiveCompanyList">
		</tbody>
	</table>
	<hr>
	<script id="tbodyActiveCompanyListTemplate"
	type="text/html"
	class="htmldb-template"
	data-htmldb-table="activeCompaniesHTMLDB"
	data-htmldb-template-target="tbodyActiveCompanyList"
	data-htmldb-filter="">
	<tr>
	<th align="left">{{id}}</th>
	<th align="left">{{company_name}}</th>
	<th>

	<button type="button"
	class="htmldb-button-edit"
	data-htmldb-edit-id="{{id}}"
	data-htmldb-table="activeCompaniesHTMLDB">Edit</button>

	</th>
	</tr>
</script>

<div id="sessionHTMLDB"
class="htmldb-table"
data-htmldb-read-url="index.php?u=session/read"
data-htmldb-write-url=""
data-htmldb-validate-url=""
data-htmldb-readonly="0"
data-htmldb-writeonly="0"
data-htmldb-priority=""></div>

<div id="companiesHTMLDB"
class="htmldb-table"
data-htmldb-read-url="index.php?u=companies/read"
data-htmldb-write-url=""
data-htmldb-validate-url=""
data-htmldb-loader=""
data-htmldb-read-loader=""
data-htmldb-write-loader=""
data-htmldb-validate-loader=""
data-htmldb-read-timer="45000"
data-htmldb-write-timer="1000"
data-htmldb-redirect=""
data-htmldb-readonly="0"
data-htmldb-writeonly="0"
data-htmldb-priority=""></div>

<div id="activeCompaniesHTMLDB"
class="htmldb-table"
data-htmldb-table="companiesHTMLDB"
data-htmldb-filter="active/eq/0"
data-htmldb-readonly="0"
data-htmldb-writeonly="0"
data-htmldb-priority=""></div>

<div id="companyUnitsHTMLDB"
class="htmldb-table"
data-htmldb-read-url="index.php?u=units/company/{{companiesHTMLDB.id}}"
data-htmldb-write-url=""
data-htmldb-validate-url=""
data-htmldb-loader=""
data-htmldb-read-loader=""
data-htmldb-write-loader=""
data-htmldb-validate-loader=""
data-htmldb-read-timer="45000"
data-htmldb-write-timer="1000"
data-htmldb-redirect=""
data-htmldb-readonly="0"
data-htmldb-writeonly="0"
data-htmldb-priority=""></div>

	<!--
	<div id="companyTypesHTMLDB"
			class="htmldb-table"
			data-htmldb-read-url=""
			data-htmldb-write-url=""
			data-htmldb-validate-url=""
			data-htmldb-loader=""
			data-htmldb-read-loader=""
			data-htmldb-write-loader=""
			data-htmldb-validate-loader=""
			data-htmldb-read-timer="45000"
			data-htmldb-write-timer="1000"
			data-htmldb-redirect=""
			data-htmldb-readonly="0"
			data-htmldb-writeonly="0"
			data-htmldb-priority=""></div>
		-->

		<script type="text/javascript" src="../source/htmldb.js"></script>

	</body>
	</html>