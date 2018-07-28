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
| `data-htmldb-field` | Specifies the field name. The parent table name is specified in the container form.<br><br>`Default Value: ""` |
| `data-htmldb-option-table` | Specifies the table that holds the options.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-option-title` | Specifies the title field name of the options in the `data-htmldb-option-table`.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-option-value` | Specifies the value field name of the options in the `data-htmldb-option-table`.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsetoptions` | Triggered when an htmldb-select element options has been set. |

#### Variables

This element has no HTMLDB variables.