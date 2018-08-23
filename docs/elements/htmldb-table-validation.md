### `htmldb-table-validation`

A container element for conditions validated locally before writing a record to `htmldb-table` element.

#### Syntax

```html
<ul class="htmldb-table-validation"
        data-htmldb-table="myTable">
    <li data-htmldb-validation="firstname/is/''">Please specify your first name.</li>
    <li data-htmldb-validation="lastname/is/''">Please specify your last name.</li>
</ul>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies table, to be validated according to the specified conditions. `Default Value: ""`<br>`Required` |
| `data-htmldb-validation` | Specifies the condition to be validated. If condition satisfied, message will be displayed as an error. Additionally, this attribute accepts mustache text notation.<br><br>`Default Value: ""`<br>`Required` |

#### Validation Syntax

HTMLDB proposes an easy way to specify conditions as an attribute value. `/` symbol is used to seperate operators and operands. 

For example,

- `"deleted/eq/0/and/enabled/eq/1"`
- `"name/isnot/''"`
- `"category/in/1,3,4"`
- `"category/is/{{category_id}}"`
- `"invoice_date/lt/{{:new Date().getTime();}}"`

#### Validation Operators

- `is` or `eq` means "equal to".
- `isnot` or `neq` means "not equal to".
- `gt` means "greater than".
- `gte` means "greater than or equal to".
- `lt` means "less than".
- `lte` means "less than or equal to".
- `in` means "in comma `,` seperated values".
- `notin` means "not in comma `,` seperated values".

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbvalidate` | Triggered when a condition is about to be validated. |
| `htmldberror` | Triggered when an error about to be displayed. |
| `htmldbsuccess` | Trigger when validation is successful. |

#### Variables

This element has no HTMLDB variables.