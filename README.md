![HTMLDB.js - A simple HTML data & template engine written in pure JavaScript](README.png "HTMLDB.js - A simple HTML data & template engine written in pure JavaScript")

# HTMLDB.js

**HTMLDB.js** is a simple HTML data & template engine. HTMLDB.js is written in pure JavaScript so that it can be used with different backend and frontend frameworks.

This repository contains HTMLDB.js core library source code.

## Installation

Installation HTMLDB is very simple. Just add `src/htmldb.js` or `dist/htmldb.min.js` in your HTML document. You don't need to initialize it with javascript. HTMLDB automatically initializes itself, on the page load.

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

Usage text goes here...

## Backend Integration

It is easy to integrate HTMLDB with your favorite backend framework. HTMLDB requests data in JSON format and uses an inner form to post data to the server.

### Request Format

A typical HTMLDB request is a JSON string with the following structure:

```javascript
{
    "c": [
        "id","column0", "column1", "column2", "columnName"
    ],
    "r": [
        ["1","This is column0 value", "Column 1 Value", "Column 2 Value", "Last column value"],
        ["2","This is column0 value", "Column 1 Value", "Column 2 Value", "Last column value"],
        ["3","This is column0 value", "Column 1 Value", "Column 2 Value", "Last column value"]
    ]
}
```

### Response Format

Usage text goes here...

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
