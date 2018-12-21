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
| `data-htmldb-add-option-caption` | Specifies the caption of the "Add New..." option. If this attribute value specified, a special option added as first option. When user clicks this option a new record form is initialized. <br><br>`Default Value: ""` |
| `data-htmldb-add-option-form` | Specifies the id of the new record form.<br><br>`Default Value: ""`<br>`Required` when `data-htmldb-add-option-caption` is specified. |
| `data-htmldb-add-option-form-defaults`| Specifies new record form defaults in JSON format. This attribute value must be specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""` |
| `data-htmldb-field` | Specifies the field name. The parent table name is specified in the container form.<br><br>`Default Value: ""` |
| `data-htmldb-option-table` | Specifies the table that holds the options.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-option-title` | Specifies the title field name of the options in the `data-htmldb-option-table`. This attribute accepts mustache text notation.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-option-value` | Specifies the value field name of the options in the `data-htmldb-option-table`. This attribute accepts mustache text notation.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsetoptions` | Triggered when an htmldb-select element options has been set. |
| `htmldbaddoptionclick` | Triggered when add new option has been clicked. |

#### Variables

This element has no HTMLDB variables.