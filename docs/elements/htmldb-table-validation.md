### `htmldb-table-validation`

A container element for conditions validated locally before writing a record to `htmldb-table` element.

#### Syntax

```html
<ul class="htmldb-table-validation"
        data-htmldb-table="myTable">
    <li data-htmldb-condition="firstname/is/''">Please specify your first name.</li>
    <li data-htmldb-condition="lastname/is/''">Please specify your last name.</li>
</ul>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies table, to be validated according to the specified conditions. `Default Value: ""`<br>`Required` |
| `data-htmldb-condition` | Specifies the condition to be validated. If condition satisfied, message will be displayed as an error. <br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbvalidate` | Triggered when a condition is about to be validated. |
| `htmldberror` | Triggered when an error about to be displayed. |
| `htmldbsuccess` | Trigger when validation is successful. |

#### Variables

This element has no HTMLDB variables.