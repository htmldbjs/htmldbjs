### `htmldb-button-save`

An action button is used for saving current values of the specified form.

#### Syntax

```html
<button class="htmldb-button-save"
        type="button"
        data-htmldb-form="myForm"
        data-htmldb-checkbox-group="">Save</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-form` | Specifies the form, that holds the record to be saved.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-checkbox-group` | This attribute specifies the checkbox group will be used to identify selected records to be updated.<br><br>`Default Value: ""` |
| `data-htmldb-form-defaults` | Specifies default fields values to be assigned. This attribute value must be in JSON format, thus specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""` |
| `data-htmldb-validate-only` | Specifies the save operation type. If the value of this attribute is `1`, then only the validation operation is performed. Write operation is not performed.<br><br>`Default Value: "0"` |
| `data-htmldb-validate-url` | Specifies the validate url to be overrided when the save operation is performed.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbbeforesave` | Triggered when an htmldb-button-save button clicked just before collecting form values. |
| `htmldbsave` | Triggered when an htmldb-button-save button clicked. |

#### Variables

This element has no HTMLDB variables.