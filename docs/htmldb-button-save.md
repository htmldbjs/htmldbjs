### `htmldb-button-save`

An action button is used for saving current values of the specified form.

#### Syntax

```html
<button class="htmldb-button-save"
        type="button"
        data-htmldb-form="myForm">Save</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-form` | Specifies the form, that holds the record to be saved.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-checkbox-group` | HTMLDB provides multiple selection of records via checkbox groups. This attribute specifies the checkbox group will be used to identify selected records to be updated.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsave` | Triggered when an htmldb-button-save button clicked. |

#### Variables

This element has no HTMLDB variables.