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

An action button is used for adding a new record to the specified table. When htmldb-button-add button clicked related forms are reset.

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
| `data-htmldb-form`         | Specifies parent form, that new record will be entered.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-form-defaults`| Specifies new record defaults in JSON format. This attribute value must be specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""`  |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbadd` | Triggered when an htmldb-button-add button clicked. |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-button-edit`

An action button is used for editing a specific record. When htmldb-button-edit button clicked htmldb-table element active id is set to the specified record. Additionally, all related form fields are populated with the values of the record.

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
| `data-htmldb-table`     | Specifies parent table, that holds the record to be edited.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-form`     | Specifies the form, that will be populated with the record in `data-htmldb-table` table specified by `data-htmldb-edit-id` value.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-edit-id`     | Specified the unique id value of the record to be edited.<br><br>`Default Value: ""`<br>`Required` |

#### Events

This element has no events.

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-button-refresh`

An action button is used for refreshing all htmldb-table elements.

#### Syntax

```html
<button class="htmldb-button-refresh"
        type="button">Refresh</button>
```

#### Attributes

This element has no attributes.

#### Events

This element has no events.

#### Examples

Examples text goes here...

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
| `data-htmldb-table`     | right-aligned<br/>test                    |
| `data-htmldb-save-delay`     | right-aligned                             |
| `data-htmldb-input-field`     | right-aligned                             |
| `data-htmldb-refresh-table`     | right-aligned                             |
| `data-htmldb-table-defaults` | right-aligned                             |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsave` | Triggered when an htmldb-button-save button clicked. |

#### Examples

Examples text goes here...

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
        data-htmldb-refresh-table="myTable2"
        data-htmldb-table-defaults='{"page":0}'>Sort Column</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table`     | right-aligned<br/>test                    |
| `data-htmldb-sort-field`     | right-aligned                             |
| `data-htmldb-sort-value`     | right-aligned                             |
| `data-htmldb-direction-field`     | right-aligned                             |
| `data-htmldb-refresh-table` | right-aligned                             |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsort` | Triggered when an htmldb-button-sort button clicked. |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-error`

A container element for the errors.

#### Syntax

```html
<script id="myFirstTemplate"
        class="htmldb-template"
        type="text/html"></script>
```

#### Attributes

This element has no attributes.

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldberror` | Triggered when an error returned especially after validation process.<br><br>`Event.detail.tableElementId` holds the table id that returned the error.<br>`Event.detail.errorText` holds the error text returned. |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-field`

An input element, that holds the current values of the htmldb-form fields.

#### Syntax

```html
<input id="name"
        name="name"
        type="text"
        value=""
        class="htmldb-field"
        data-htmldb-field="company_name">
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-field`     | right-aligned<br/>test                    |
| `data-htmldb-value`     | right-aligned                             |
| `data-htmldb-reset-value`     | right-aligned                             |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsetvalue` | Triggered when HTMLDB sets the htmldb-field input value.<br><br>`Event.detail.value` holds the value has been set. |
| `htmldbgetvalue` | Triggered when HTMLDB is about to get the htmldb-field input value. |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-form`

A container for the htmldb-fields, that automatically updated by htmldb-table.

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
| `data-htmldb-table`     | right-aligned<br/>test                    |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbreset` | Triggered when HTMLDB resets the htmldb-form form element. |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-input-save`

A standalone input that automatically update the specific htmldb-table record.

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
| `data-htmldb-table`     | right-aligned<br/>test                    |
| `data-htmldb-save-delay`     | right-aligned                             |
| `data-htmldb-input-field`     | right-aligned                             |
| `data-htmldb-refresh-table`     | right-aligned                             |
| `data-htmldb-table-defaults` | right-aligned                             |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsave` | Triggered when an htmldb-input-save input has been saved. |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-message`

A container element for the messages.

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

This element has no attributes.

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbmessage` | Triggered when a message returned especially after validation process.<br><br>`Event.detail.tableElementId` holds the table id that returned the message.<br>`Event.detail.messageText` holds the message text returned. |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-pagination`

A container element for easily navigating among the pages of htmldb-table element.

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
| `data-htmldb-table`     | right-aligned<br/>test                    |
| `data-htmldb-refresh-table`     | right-aligned                             |
| `data-htmldb-page-field`     | right-aligned                             |
| `data-htmldb-page-count-field`     | right-aligned                             |
| `data-htmldb-page` | right-aligned                             |
| `data-htmldb-page-count`    | right-aligned                             |
| `data-htmldb-table-defaults`    | right-aligned                             |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbrender` | Triggered when an htmldb-pagination element has been rendered. |
| `htmldbpageclick` | Triggered when a page element clicked within an htmldb-pagination element.<br><br>`Event.detail.page` holds the page index. |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-section`

A container for the elements, that automatically rendered by the related htmldb-table.

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
| `data-htmldb-table`     | right-aligned<br/>test                    |
| `data-htmldb-content`     | right-aligned                             |

#### Events

This element has no events.

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-select`

A select element that automatically populated with the related htmldb-table.

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
| `data-htmldb-field`     | right-aligned<br/>test                    |
| `data-htmldb-option-table`     | right-aligned                             |
| `data-htmldb-option-title`     | right-aligned                             |
| `data-htmldb-option-value`     | right-aligned                             |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsetoptions` | Triggered when an htmldb-select element options has been set. |

#### Examples

Examples text goes here...

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
| `data-htmldb-loader` |   |
| `data-htmldb-local` | Specifies whether HTMLDB table instance will store data in browser's local storage (IndexedDB) or not. Local HTMLDB table instances are not automatically retreive data from the server or post data to the server. It stores all the data in IndexedDB. Local HTMLDB table instances use `HTMLDB` as database name and HTMLDB table element `id` for object store name. Local HTMLDB table data can be accessible from all pages in the same domain.<br><br>`Default Value: false` |
| `data-htmldb-priority` | Specifies the loading priority of the HTMLDB table.<br><br>`Default Value: 0` |
| `data-htmldb-read-loader` |   |
| `data-htmldb-read-url` | Specifies the URL of the data requested from the server.<br><br>`Default Value: ""` |
| `data-htmldb-read-only` | Specifies that HTMLDB table instance is read-only or not.<br><br>`Default Value: false` |
| `data-htmldb-redirect` | Specifies the redirect URL after posting data to the server.<br><br>`Default Value: ""` |
| `data-htmldb-table` | Specifies the parent HTMLDB table `id`. This attribute is used with `data-htmldb-table`.<br><br>`Default Value: ""` |
| `data-htmldb-validate-loader` |   |
| `data-htmldb-validate-url` | Specifies the URL that simulates posting data to the server for validation.<br><br>`Default Value: ""` |
| `data-htmldb-write-loader` |   |
| `data-htmldb-form` |   |
| `data-htmldb-loading` |   |
| `data-htmldb-active-id` |   |
| `data-htmldb-read-incremental` |   |
| `data-htmldb-write-url` | Specifies the data post URL.<br><br>`Default Value: ""` |
| `data-htmldb-write-only` | Specifies that HTMLDB table instance is write-only or not.<br><br>`Default Value: false` |
| `id` | Specifies the name of the HTMLDB table.<br><br>`Default Value: ""`<br>`Required`<br>`Unique` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldberror` | Triggered when an error returned especially after validation process.<br><br>`Event.detail.errorText` holds the error text returned. |
| `htmldbmessage` | Triggered when a message returned especially after validation process.<br><br>`Event.detail.messageText` holds the message text returned. |

#### Examples

- Basic HTMLDB Table Example
- HTMLDB Table Filter Example
- Local HTMLDB Example

<br/>
<br/>

### `htmldb-template`

A container element for the templates, that are automatically rendered by related htmldb-table.

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
| `data-htmldb-table`     | right-aligned<br/>test                    |
| `data-htmldb-template-target`     | right-aligned                             |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbrender` | Triggered when an htmldb-template element has been rendered. |

#### Examples

Examples text goes here...

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
| `data-htmldb-table`     | right-aligned<br/>test                    |
| `data-htmldb-filter`     | right-aligned                             |

#### Events

This element has no events.

#### Examples

Examples text goes here...

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
