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
| `data-htmldb-checkbox-group` | HTMLDB provides multiple selection of records via checkbox groups. This attribute specifies the checkbox group will be used to identify selected records to be updated.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsave` | Triggered when an htmldb-input-save input has been saved. |

#### Variables

This element has no HTMLDB variables.