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

#### Variables

This element has no HTMLDB variables.