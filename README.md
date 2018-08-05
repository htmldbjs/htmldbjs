![HTMLDB.js - A simple HTML data & template engine written in pure JavaScript](README.png "HTMLDB.js - A simple HTML data & template engine written in pure JavaScript")

# HTMLDB.js

**HTMLDB.js** is a simple HTML data & template engine. HTMLDB.js is written in pure JavaScript so that it can be used with different backend and frontend frameworks.

This repository contains HTMLDB.js core library source code.

<br/>

## Installation

Installation HTMLDB is very simple. Just add `src/htmldb.js` or `dist/htmldb.min.js` in your HTML document. You don't need to initialize it with javascript. On the page load, HTMLDB automatically initializes itself.

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>My HTMLDB Page</title>
    <!--
    htmldb.min.js file location can change based on your directory structure.
    -->
    <script type="text/javascript" src="htmldb.min.js"></script>
  </head>
  <body>
  </body>
</html>
```

<br/>

## Usage

Firstly, create an HTMLDB table. HTMLDB tables are like database tables, they have columns and rows. In this case we have a table to list our friends.

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>My HTMLDB Page</title>

    <div id="friendsHTMLDB" class="htmldb-table" data-htmldb-read-url="friends/read"></div>

    <script type="text/javascript" src="htmldb.min.js"></script>
  </head>
  <body>
  </body>
</html>
```

In the above example, we use a container `<div>` element for storing server side data (e.g. friends) in HTML format. This `<div>` must have a unique id attribute. By using a special class name `htmldb-table`, we specify this `<div>` as an HTMLDB table. Additionally, we use special attributes starting with `data-htmldb-` to define properties of HTMLDB elements. In this case we use `data-htmldb-read-url` for specifying the source URL of HTMLDB table that friends data will be loaded.

Let's assume friends data loaded from the server are as follows:

```javascript
{
    "c": [
        "id", "firstname", "lastname"
    ],
    "r": [
        ["1", "Rachel", "Green"],
        ["2", "Phoebe", "Buffay"],
        ["3", "Monica", "Geller"],
        ["4", "Chandler", "Bing"],
        ["5", "Joey", "Tribbiani"],
        ["6", "Ross", "Geller"],
    ]
}
```

Let's list our friends with a template.

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>My HTMLDB Page</title>

    <div id="friendsHTMLDB" class="htmldb-table" data-htmldb-read-url="friends/read"></div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody id="friendsList"></tbody>
    </table>

    <script type="text/html" id="friendsListTemplate" class="htmldb-template"
            data-htmldb-table="friendsHTMLDB" data-htmldb-template-target="friendsList">
        <tr data-row-id="{{id}}">
            <td>{{id}}</td>
            <td>{{firstname}}</td>
            <td>{{lastname}}</td>
        </tr>
    </script>

    <script type="text/javascript" src="htmldb.min.js"></script>
  </head>
  <body>
  </body>
</html>
```

In the example above, there is a `<table>` with an empty `<tbody>` element. This empty `<tbody>` element will contain list of friends after the page load with the specified template. `<tbody>` element has an `id` attribute with the value `"friendsList"`.

Additionally, there is a `<script>` element with `type="text/html"` attribute. This `<script>` element contains list template with mustache text fields.

After loading page, this HTML will look like as the following:

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>My HTMLDB Page</title>

    <div id="friendsHTMLDB" class="htmldb-table" data-htmldb-read-url="friends/read">
        <!-- HTMLDB table runtime content -->
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody id="friendsList">
            <tr data-row-id="1">
                <td>1</td>
                <td>Rachel</td>
                <td>Green</td>
            </tr>
            <tr data-row-id="2">
                <td>2</td>
                <td>Phoebe</td>
                <td>Buffay</td>
            </tr>
            <tr data-row-id="3">
                <td>3</td>
                <td>Monica</td>
                <td>Geller</td>
            </tr>
            <tr data-row-id="4">
                <td>4</td>
                <td>Chandler</td>
                <td>Bing</td>
            </tr>
            <tr data-row-id="5">
                <td>5</td>
                <td>Joey</td>
                <td>Tribbiani</td>
            </tr>
            <tr data-row-id="6">
                <td>6</td>
                <td>Ross</td>
                <td>Geller</td>
            </tr>
        </tbody>
    </table>

    <script type="text/html" id="friendsListTemplate" class="htmldb-template"
            data-htmldb-table="friendsHTMLDB" data-htmldb-template-target="friendsList">
        <tr data-row-id="{{id}}">
            <td>{{id}}</td>
            <td>{{firstname}}</td>
            <td>{{lastname}}</td>
        </tr>
    </script>

    <script type="text/javascript" src="htmldb.min.js"></script>
  </head>
  <body>
  </body>
</html>
```

<br/>

## Backend Integration

It is easy to integrate HTMLDB with your favorite backend framework. HTMLDB requests data in JSON format and uses an inner form to post data to the server.

<br/>

### Request Format

A typical HTMLDB request is a JSON string with the following format:

```javascript
{
    "c": [
        "id", "column0", "column1", "column2", "columnName"
    ],
    "r": [
        ["1", "This is column0 value", "Column 1 Value", "Column 2 Value", "Last column value"],
        ["2", "This is column0 value", "Column 1 Value", "Column 2 Value", "Last column value"],
        ["3", "This is column0 value", "Column 1 Value", "Column 2 Value", "Last column value"]
    ]
}
```

<br/>

### Response Format

HTMLDB uses an inner HTML form element to post data to the server with the following format:

```
htmldb_action0: inserted
htmldb_row0_id: 1
htmldb_row0_column0: column0 new value  
htmldb_row0_column1: column1 new value
htmldb_row0_column2: column2 new value
htmldb_row0_columnName: columnName new value
```

The above example shows single-row post parameters. For posting multiple rows the following format is used:

```
htmldb_action0: inserted
htmldb_row0_id: 1
htmldb_row0_column0: column0 new value  
htmldb_row0_column1: column1 new value
htmldb_row0_column2: column2 new value
htmldb_row0_columnName: columnName new value
htmldb_action1: inserted
htmldb_row1_id: 2
htmldb_row1_column0: column0 new value  
htmldb_row1_column1: column1 new value
htmldb_row1_column2: column2 new value
htmldb_row1_columnName: columnName new value
htmldb_action2: inserted
htmldb_row2_id: 3
htmldb_row2_column0: column0 new value  
htmldb_row2_column1: column1 new value
htmldb_row2_column2: column2 new value
htmldb_row2_columnName: columnName new value
```

<br/>

## Elements

| Element Name | Description  |
| ---- | ---- |
| [`htmldb-button-add`](docs/htmldb-button-add.md) | An action button is used for adding a new record to the specified table. When `htmldb-button-add` button is clicked related forms are reset. |
| [`htmldb-button-edit`](docs/htmldb-button-edit.md) | An action button is used for editing a specific record. When `htmldb-button-edit` button is clicked `htmldb-table` element's active id is set to the specified record. Additionally, all related form fields are populated with the values of the record. |
| [`htmldb-button-refresh`](docs/htmldb-button-refresh.md) | An action button is used for refreshing all `htmldb-table` elements. |
| [`htmldb-button-save`](docs/htmldb-button-save.md) | An action button is used for saving current values of the specified form. |
| [`htmldb-button-sort`](docs/htmldb-button-sort.md) | An action button is used for updating the sorting preferences. |
| [`htmldb-checkbox-group`](docs/htmldb-checkbox-group.md) | A container element for checkbox inputs. `htmldb-checkbox-group` makes it possible to select/update/delete multiple records. |
| [`htmldb-error`](docs/htmldb-error.md) | A container element for the errors. |
| [`htmldb-field`](docs/htmldb-field.md) | An input element, that holds the current values of the `htmldb-form` fields. |
| [`htmldb-form`](docs/htmldb-form.md) | A container for the `htmldb-field` elements, that automatically updated by `htmldb-table`. |
| [`htmldb-input-save`](docs/htmldb-input-save.md) | A standalone input that automatically update the specific `htmldb-table` record. |
| [`htmldb-message`](docs/htmldb-message.md) | A container element for the messages. |
| [`htmldb-pagination`](docs/htmldb-pagination.md) | A container element for easily navigating among the pages of `htmldb-table` element. |
| [`htmldb-section`](docs/htmldb-section.md) | A container for the elements, that automatically rendered by the related `htmldb-table`. |
| [`htmldb-select`](docs/htmldb-select.md) | A select element that automatically populated with the related `htmldb-table`. |
| [`htmldb-table`](docs/htmldb-table.md) | Data source element that retrieves and stores data from the server. Also, it validates and posts data to the server. |
| [`htmldb-table-validation`](docs/htmldb-table-validation.md) | A container element for conditions validated locally before writing a record to `htmldb-table` element. |
| [`htmldb-template`](docs/htmldb-template.md) | A container element for the templates, that are automatically rendered by related `htmldb-table`. |
| [`htmldb-toggle`](docs/htmldb-toggle.md) | A special container for the form fields that automatically displayed or hided for a certain condition. |

<br/>

## Global Variables

HTMLDB provides some critical information in global variables. This global variables can be used in mustache templates.

<br/>

### `$URL`

`$URL` global variable holds the URL address of the current page. You can access URL parameters with `$URL.parameter` notation. Additionally `$URL` accepts integer parameter indices e.g. `$URL.1` or `$URL.-1`. `$URL.1` gives the first URL parameter value. `$URL.-1` gives the last URL parameter value.

<br/>

## Using Other Table Fields and Element Variables in Mustache Templates

In some cases, it is required to use other table fields and/or element variables (e.g. current page index, page count, checked record count, etc.) in mustache templates. `htmldb-table` fields are accessible using `{{TableName.FieldName}}` notation, and also `htmldb-pagination`, `htmldb-checkbox-group` variables using `{{ElementID.VariableName}}` in mustache templates. HTMLDB uses active records of the `htmldb-table` instances while parsing mustache templates.

```html
<form id="myForm"
        name="myForm"
        method="post"
        class="htmldb-form"
        data-htmldb-table="myTable">

    <input id="company_id"
            name="company_id"
            type="hidden"
            value=""
            class="htmldb-field"
            data-htmldb-field="company_id"
            data-htmldb-reset-value="{{companyTable.id}}">

    <input id="name"
            name="name"
            type="text"
            value=""
            class="htmldb-field"
            data-htmldb-field="company_name">

</form>

<div id="companyTable"
        class="htmldb-table"
        data-htmldb-read-url="company/read"
        data-htmldb-validate-url="company/validate"
        data-htmldb-write-url="company/write"></div>

<div id="myFirstTable"
        class="htmldb-table"
        data-htmldb-read-url="myfirsttable/read"
        data-htmldb-validate-url="myfirsttable/validate"
        data-htmldb-write-url="myfirsttable/write"></div>
```

In the example above, there is a form and two `htmldb-table` instances called `companyTable` and `myFirstTable` respectively. Also, the form has two inputs. The first input is a hidden input that holds predefined `company_id` value from `companyTable`. In this case, `data-htmldb-reset-value` attribute must be specified with the value `{{companyTable.id}}`. So, `company_id` input value will be automatically reset to the `id` value of the active record in `companyTable` instance.

## Using Javascript Functions and Variables in Mustache Templates

Using Javascript variables and functions in mustache templates can be a time-saver. It is very easy to use global Javascript functions and variables in HTMLDB mustache templates.

```html
<form id="myForm"
        name="myForm"
        method="post"
        class="htmldb-form"
        data-htmldb-table="myTable">

    <input id="company_guid"
            name="company_guid"
            type="hidden"
            value=""
            class="htmldb-field"
            data-htmldb-field="company_guid"
            data-htmldb-reset-value="{{:generateCompanyGUID();}}">

    <input id="company_calculated_field"
            name="company_calculated_field"
            type="hidden"
            value=""
            class="htmldb-field"
            data-htmldb-field="company_calculated_field"
            data-htmldb-reset-value="{{:2+3;}}">

    <input id="company_special_field"
            name="company_calculated_field"
            type="hidden"
            value=""
            class="htmldb-field"
            data-htmldb-field="company_calculated_field"
            data-htmldb-reset-value="{{:Math.sin(Math.PI / 2);}}">

```

<br/>

## Contributing

Please use the [issue tracker](https://github.com/htmldbjs/htmldbjs/issues) to report any bugs/typos or requests.

<br/>

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/htmldbjs/htmldbjs/tags). 

<br/>

## Authors

* **Aykut Aydınlı** - [@aykutaydinli](https://github.com/aykutaydinli)

<br/>

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
