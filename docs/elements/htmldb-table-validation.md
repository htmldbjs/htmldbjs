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
| `data-htmldb-validation` | Specifies the condition to be validated. If condition satisfied, message will be displayed as an error. This attribute accepts mustache text notation.<br><br>
Validation Syntax: field_name1/operator1/value1/and,or/field_name2/operator2/value2<br><br>
Operators:<br>
- `is` or `eq` means "equal to".
- `isnot` or `neq` means "not equal to".
- `gt` means "greater than".
- `gte` means "greater than or equal to".
- `lt` means "less than".
- `lte` means "less than or equal to".
- `in` means "in comma `,` seperated values".
- `notin` means "not in comma `,` seperated values".
<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbvalidate` | Triggered when a condition is about to be validated. |
| `htmldberror` | Triggered when an error about to be displayed. |
| `htmldbsuccess` | Trigger when validation is successful. |

#### Variables

This element has no HTMLDB variables.