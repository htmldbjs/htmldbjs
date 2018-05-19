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

In the above example, we use a container `<div>` element for storing server side data (e.g. friends) in HTML format. This `<div>` must have a unique id attribute. By using a special class name `htmldb-table`, we specify this `<div>` as an HTMLDB table. Additionally, we use special attributes starting with `data-htmldb-` to define properties of HTMLDB elements. In this case we use `data-htmldb-read-url` for specifying the source url of HTMLDB table that friends data will be loaded.

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

    <div id="friendsHTMLDB" class="htmldb-table" data-htmldb-read-url="friends/read"></div>

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

A typical HTMLDB request is a JSON string with the following structure:

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

HTMLDB uses an inner HTML form element to post data to the server with the following structure:

```
htmldb_action0:	inserted
htmldb_row0_id: 1
htmldb_row0_column0: column0 new value	
htmldb_row0_column1: column1 new value
htmldb_row0_column2: column2 new value
htmldb_row0_columnName: columnName new value
```

The above example shows single-row post parameters. For posting multiple rows the following structure is used:

```
htmldb_action0:	inserted
htmldb_row0_id: 1
htmldb_row0_column0: column0 new value	
htmldb_row0_column1: column1 new value
htmldb_row0_column2: column2 new value
htmldb_row0_columnName: columnName new value
htmldb_action1:	inserted
htmldb_row1_id: 2
htmldb_row1_column0: column0 new value	
htmldb_row1_column1: column1 new value
htmldb_row1_column2: column2 new value
htmldb_row1_columnName: columnName new value
htmldb_action2:	inserted
htmldb_row2_id: 3
htmldb_row2_column0: column0 new value	
htmldb_row2_column1: column1 new value
htmldb_row2_column2: column2 new value
htmldb_row2_columnName: columnName new value
```

## Elements

### `htmldb-table`

Usage text goes here...

#### Syntax

```html
<div id="myFirstTable" class="htmldb-table" data-htmldb-read-url="myfirsttable.json"></div>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-template`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-section`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes
| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-form`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-field`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-error`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-message`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-toggle`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-button-refresh`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-button-add`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-button-edit`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

#### Examples

Examples text goes here...

<br/>
<br/>

### `htmldb-button-save`

Usage text goes here...

#### Syntax

```html
<script id="myFirstTemplate" class="htmldb-template" type="text/html"></script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-priority`     | right-aligned<br/>test                    |
| `data-htmldb-read-url`     | right-aligned                             |
| `data-htmldb-readonly`     | right-aligned                             |
| `data-htmldb-redirect`     | right-aligned                             |
| `data-htmldb-validate-url` | right-aligned                             |
| `data-htmldb-write-url`    | right-aligned                             |
| `data-htmldb-writeonly`    | right-aligned                             |

#### Events

| Event Name               | Description                               |
| ------------------------ | ----------------------------------------- |
| `htmldbread`             | right-aligned                             |
| `htmldbwrite`            | right-aligned                             |
| `htmldbvalidate`         | right-aligned                             |

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
