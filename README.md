![HTMLDB.js - A simple HTML data & template engine written in pure JavaScript](README.png "HTMLDB.js - A simple HTML data & template engine written in pure JavaScript")

# HTMLDB.js

**HTMLDB.js** is a simple HTML data & template engine. HTMLDB.js is written in pure JavaScript so that it can be used with different backend and frontend frameworks.

This repository contains HTMLDB.js core library source code.

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

## Backend Integration

It is easy to integrate HTMLDB with your favorite backend framework. HTMLDB requests data in JSON format and uses an inner form to post data to the server.

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

## Elements

### `htmldb-button-add`

An action button is used for adding a new record to the specified table. When `htmldb-button-add` button is clicked related forms are reset.

#### Syntax

```html
<button class="htmldb-button-add"
        type="button"
        data-htmldb-form="myForm"
        data-htmldb-form-defaults='{"enabled":1}'>Add New Record</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-form` | Specifies parent form, that new record will be entered.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-form-defaults`| Specifies new record defaults in JSON format. This attribute value must be specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbadd` | Triggered when an htmldb-button-add button clicked. |

<br/>
<br/>

### `htmldb-button-edit`

An action button is used for editing a specific record. When `htmldb-button-edit` button is clicked `htmldb-table` element's active id is set to the specified record. Additionally, all related form fields are populated with the values of the record.

#### Syntax

```html
<button class="htmldb-button-edit"
        type="button"
        data-htmldb-edit-id="1"
        data-htmldb-table="myTable"
        data-htmldb-form="myForm">Edit Record</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies parent table, that holds the record to be edited.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-form` | Specifies the form, that will be populated with the record in `data-htmldb-table` table specified by `data-htmldb-edit-id` value.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-edit-id` | Specified the unique id value of the record to be edited.<br><br>`Default Value: ""`<br>`Required` |

#### Events

This element has no HTMLDB events.

<br/>
<br/>

### `htmldb-button-refresh`

An action button is used for refreshing all `htmldb-table` elements.

#### Syntax

```html
<button class="htmldb-button-refresh"
        type="button">Refresh</button>
```

#### Attributes

This element has no HTMLDB attributes.

#### Events

This element has no HTMLDB events.

<br/>
<br/>

### `htmldb-button-save`

An action button is used for saving current values of the specified form.

#### Syntax

```html
<button class="htmldb-button-save"
        type="button"
        data-htmldb-form="myForm">Save</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-form` | Specifies the form, that holds the record to be saved.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsave` | Triggered when an htmldb-button-save button clicked. |

<br/>
<br/>

### `htmldb-button-sort`

An action button is used for updating the sorting preferences.

#### Syntax

```html
<button type="button"
        class="htmldb-button-sort"
        data-htmldb-table="myTable"
        data-htmldb-sort-field="sortingColumn"
        data-htmldb-sort-value="0"
        data-htmldb-direction-field="sortingASC"
        data-htmldb-refresh-table="myTable2,myTable3"
        data-htmldb-table-defaults='{"page":0}'>Sort Column</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies table, that holds the sorting configuration. When user clicks the `htmldb-button-sort` button, sorting configuration specified by `data-htmldb-sort-field`, `data-htmldb-sort-value` and `data-htmldb-direction-field` is saved to this table.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-sort-field` | Specifies the sort field in the `data-htmldb-table` table.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-sort-value` | Specifies the sort field value, that holds the column id, index or name to be saved when the user clicks this button.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-direction-field` | Specifies the sort direction (Ascending or Descending) field in the `data-htmldb-table` table. Value of this field is automatically determined by the current state of this button. Additionally, an extra class is added according to the state of this button. If the sorting direction is ascending, `htmldb-sorting-asc` class is added. If the sorting direction is descending, `htmldb-sorting-desc` class is added.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-refresh-table` | Specifies the table(s), that will refreshed after sorting configuration is saved. This attribute can hold more than one HTMLDB table seperating with comma `,` symbol.<br><br>`Default Value: ""` |
| `data-htmldb-sorting-asc` | Specifies the current sorting direction. If the sorting direction is ascending, the value of this attribute is `1`, otherwise the value of this attribute is `0`.<br><br>`Default Value: "0"`<br>`Read-Only` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsort` | Triggered when an htmldb-button-sort button clicked. |

<br/>
<br/>

### `htmldb-error`

A container element for the errors.

#### Syntax

```html
<div class="htmldb-error"
        data-htmldb-table="myTable"></div>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, whose errors will be printed in this element.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldberror` | Triggered when an error returned especially after validation process.<br><br>`Event.detail.tableElementId` holds the table id that returned the error.<br>`Event.detail.errorText` holds the error text returned. |

<br/>
<br/>

### `htmldb-field`

An input element, that holds the current values of the `htmldb-form` fields.

#### Syntax

```html
<form id="myForm"
        name="myForm"
        method="post"
        class="htmldb-form"
        data-htmldb-table="myTable">

    <input id="name"
            name="name"
            type="text"
            value=""
            class="htmldb-field"
            data-htmldb-field="company_name">

</form>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-field` | Specifies the field name. The parent table name is specified in the container form.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-value` | Specifies the field value in mustache text notation (e.g. `{{id}}`, `{{name}}`).<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-reset-value` | Specifies the value of the element, after container form is reset.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsetvalue` | Triggered when HTMLDB sets the htmldb-field input value.<br><br>`Event.detail.value` holds the value has been set. |
| `htmldbgetvalue` | Triggered when HTMLDB is about to get the htmldb-field input value. |

<br/>
<br/>

### `htmldb-form`

A container for the `htmldb-field` elements, that automatically updated by `htmldb-table`.

#### Syntax

```html
<form id="myForm"
        name="myForm"
        method="post"
        class="htmldb-form"
        data-htmldb-table="myTable">

</form>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table of the form.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbreset` | Triggered when HTMLDB resets the htmldb-form form element. |

<br/>
<br/>

### `htmldb-input-save`

A standalone input that automatically update the specific `htmldb-table` record.

#### Syntax

```html
<input id="name"
        name="name"
        class="htmldb-input-save"
        type="search"
        data-htmldb-table="myTable"
        data-htmldb-input-field="company_name"
        data-htmldb-refresh-table="myTable2"
        data-htmldb-table-defaults='{"page":0}'
        data-htmldb-save-delay="1000">
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, to be updated.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-save-delay` | Specifies the delay time between update operations. This attribute is very useful when using `htmldb-input-save` with text inputs.<br><br>`Default Value: "500"` |
| `data-htmldb-input-field` | Specifies the field name in the `data-htmldb-table` to be updated.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-refresh-table` | Specifies the table(s), that will refreshed after saving. This attribute can hold more than one HTMLDB table seperating with comma `,` symbol.<br><br>`Default Value: ""` |
| `data-htmldb-table-defaults` | Specifies extra fields to be updated. This attribute value must be in JSON format, thus specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsave` | Triggered when an htmldb-input-save input has been saved. |

<br/>
<br/>

### `htmldb-message`

A container element for the messages.

#### Syntax

```html
<div class="htmldb-message"
        data-htmldb-table="myTable"></div>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, whose messages will be printed in this element.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbmessage` | Triggered when a message returned especially after validation process.<br><br>`Event.detail.tableElementId` holds the table id that returned the message.<br>`Event.detail.messageText` holds the message text returned. |

<br/>
<br/>

### `htmldb-pagination`

A container element for easily navigating among the pages of `htmldb-table` element.

#### Syntax

```html
<ul class="htmldb-pagination"
        data-htmldb-table="myTable"
        data-htmldb-page-field="page"
        data-htmldb-page-count-field="pageCount"
        data-htmldb-refresh-table="myTable2"
        data-htmldb-table-defaults="">

    <li class="htmldb-pagination-template htmldb-pagination-previous">

        <button class="htmldb-button-page">Previous</button>

    </li>

    <li class="htmldb-pagination-template htmldb-pagination-next">

        <button class="htmldb-button-page">Next</button>

    </li>

    <li class="htmldb-pagination-template htmldb-pagination-default">

        <button class="htmldb-button-page">

            <span data-htmldb-content="{{page}}"></span>

        </button>

    </li>

    <li class="htmldb-pagination-template htmldb-pagination-active">

        <button class="htmldb-button-page">

            <span data-htmldb-content="{{page}}"></span>

        </button>

    </li>

    <li class="htmldb-pagination-template htmldb-pagination-hidden">

        <button class="htmldb-button-page" disabled="disabled">

            <span>...</span>

        </button>

    </li>

</ul>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies table, that holds the pagination configuration. When user clicks the a page in `htmldb-pagination`, pagination configuration specified by `data-htmldb-page-field` is saved to this table.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-refresh-table` | Specifies the table(s), that will refreshed after a page is clicked in `htmldb-pagination`  element. This attribute can hold more than one HTMLDB table seperating with comma `,` symbol.<br><br>`Default Value: ""` |
| `data-htmldb-page-field` | Specifies the field name that holds the current page index starting from `0`.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-page-count-field` | Specifies the field name that holds page count.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-page` | Specifies the current page index starting from `0`.<br><br>`Default Value: ""`<br>`Read-Only` |
| `data-htmldb-page-count` | Specifies the current page count.<br><br>`Default Value: ""`<br>`Read-Only` |
| `data-htmldb-table-defaults` | Specifies extra fields to be updated when a user clicks a page in `htmldb-pagination`. This attribute value must be in JSON format, thus specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbrender` | Triggered when an htmldb-pagination element has been rendered. |
| `htmldbpageclick` | Triggered when a page element clicked within an htmldb-pagination element.<br><br>`Event.detail.page` holds the page index. |

<br/>
<br/>

### `htmldb-section`

A container for the elements, that automatically rendered by the related `htmldb-table`.

#### Syntax

```html
<div class="htmldb-section" data-htmldb-table="myTable">
    
    <p>First Name:</p>
    
    <p data-htmldb-content="{{firstname}}"></p>
    
    <p>Last Name:</p>
    
    <p data-htmldb-content="{{lastname}}"></p>
    
    <p>E-mail Address:</p>
    
    <p data-htmldb-content="{{email}}"></p>

</div>
```

#### Attributes
| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, that will automatically update the mustache text templates in the `htmldb-section` element.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-content` | Specifies the mustache text template that will be copied into the inner HTML of the element in the `htmldb-section` element.<br><br>`Default Value: ""` |

#### Events

This element has no HTMLDB events.

<br/>
<br/>

### `htmldb-select`

A select element that automatically populated with the related `htmldb-table`.

#### Syntax

```html
<select id="mySelect"
        name="mySelect"
        class="htmldb-select htmldb-field"
        data-htmldb-field="company_type"
        data-htmldb-option-table="companyTypes"
        data-htmldb-option-value="{{id}}"
        data-htmldb-option-title="{{company_type}}"></select>
```

#### Attributes
| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-field` | Specifies the field name. The parent table name is specified in the container form.<br><br>`Default Value: ""`<br><br>`Default Value: ""` |
| `data-htmldb-option-table` | Specifies the table that holds the options.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-option-title` | Specifies the title field name of the options in the `data-htmldb-option-table`.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-option-value` | Specifies the value field name of the options in the `data-htmldb-option-table`.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsetoptions` | Triggered when an htmldb-select element options has been set. |

<br/>
<br/>

### `htmldb-table`

Data source element that retrieves and stores data from the server. Also, it validates and posts data to the server.

#### Syntax

```html
<div id="myFirstTable"
        class="htmldb-table"
        data-htmldb-read-url="myfirsttable/read"
        data-htmldb-validate-url="myfirsttable/write"
        data-htmldb-write-url="myfirsttable/write"></div>
```

#### Attributes

| Attribute Name | Description |
| ---- | ---- |
| `data-htmldb-filter` | Specifies filter expression will be used while reading data from a parent HTMLDB table instance. This attribute is used with `data-htmldb-table`.<br><br>`Default Value: ""`<br> |
| `data-htmldb-loader` | Specifies the loader element id that will be shown on all read, validate and write operations.<br><br>`Default Value: ""` |
| `data-htmldb-local` | Specifies whether HTMLDB table instance will store data in browser's local storage (IndexedDB) or not. Local HTMLDB table instances are not automatically retreive data from the server or post data to the server. It stores all the data in IndexedDB. Local HTMLDB table instances use `HTMLDB` as database name and HTMLDB table element `id` for object store name. Local HTMLDB table data can be accessible from all pages in the same domain.<br><br>`Default Value: "0"` |
| `data-htmldb-priority` | Specifies the loading priority of the HTMLDB table.<br><br>`Default Value: "0"` |
| `data-htmldb-read-loader` | Specifies the loader element id that will be shown only on read operations.<br><br>`Default Value: ""` |
| `data-htmldb-read-url` | Specifies the URL of the data requested from the server.<br><br>`Default Value: ""` |
| `data-htmldb-read-only` | Specifies that HTMLDB table instance is read-only or not.<br><br>`Default Value: "0"` |
| `data-htmldb-redirect` | Specifies the redirect URL after posting data to the server.<br><br>`Default Value: ""` |
| `data-htmldb-table` | Specifies the parent HTMLDB table `id`. This attribute is used with `data-htmldb-table`.<br><br>`Default Value: ""` |
| `data-htmldb-validate-loader` | Specifies the loader element id that will be shown only on validate operations.<br><br>`Default Value: ""` |
| `data-htmldb-validate-url` | Specifies the URL that simulates posting data to the server for validation.<br><br>`Default Value: ""` |
| `data-htmldb-write-loader` | Specifies the loader element id that will be shown only on write operations.<br><br>`Default Value: ""` |
| `data-htmldb-form` | Specifies the target form that will be updated after read operations.<br><br>`Default Value: ""` |
| `data-htmldb-loading` | Specifies the table is loading or not.<br><br>`Default Value: ""`<br>`Read-Only` |
| `data-htmldb-active-id` | Specifies the current id (like cursor) of the table. After loading/refreshing, active id is automatically reset to first id in the list.<br><br>`Default Value: ""`<br>`Read-Only` |
| `data-htmldb-read-incremental` | Specifies that read operations will be incremental or not. In incremental read operations, the table records are not cleared. All read operations are added at the end of the list.<br><br>`Default Value: "0"` |
| `data-htmldb-write-url` | Specifies the data post URL.<br><br>`Default Value: ""` |
| `data-htmldb-write-only` | Specifies that HTMLDB table instance is write-only or not.<br><br>`Default Value: "0"` |
| `id` | Specifies the name of the HTMLDB table.<br><br>`Default Value: ""`<br>`Required`<br>`Unique` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldberror` | Triggered when an error returned especially after validation process.<br><br>`Event.detail.errorText` holds the error text returned. |
| `htmldbmessage` | Triggered when a message returned especially after validation process.<br><br>`Event.detail.messageText` holds the message text returned. |

<br/>
<br/>

### `htmldb-template`

A container element for the templates, that are automatically rendered by related `htmldb-table`.

#### Syntax

```html
<table id="myTemplateTarget"></table>

<script type="text/html"
        id="myTemplate"
        class="htmldb-template"
        data-htmldb-table="myTable"
        data-htmldb-template-target="myTemplateTarget">

        <tr class="tr{{id}}" data-object-id="{{id}}">

            <td>{{id}}</td>

            <td>{{company_name}}</td>

            <td>{{company_type}}</td>

        </tr>

</script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, that will be used to render this template.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-template-target` | Specifies the target element id, which will be populated after rendering this template.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbrender` | Triggered when an htmldb-template element has been rendered. |

<br/>
<br/>

### `htmldb-toggle`

A special container for the form fields that automatically displayed or hided for a certain condition.

#### Syntax

```html
<div id="myContainer"
        class="htmldb-toggle"
        data-htmldb-filter="company_type/eq/1">

    <p>Company Type: 1</p>

</div>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-filter` | Specifies the condition according to the values of the container form that make this element visible.<br><br>`Default Value: ""`<br>`Required` |
 
#### Events

This element has no HTMLDB events.

<br/>
<br/>

## Contributing

Please use the [issue tracker](https://github.com/htmldbjs/htmldbjs/issues) to report any bugs/typos or requests.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/htmldbjs/htmldbjs/tags). 

## Authors

* **Aykut Aydınlı** - [@aykutaydinli](https://github.com/aykutaydinli)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
