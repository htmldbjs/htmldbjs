### `htmldb-error`

A container element for the errors.

#### Syntax

```html
<div class="htmldb-error"
        data-htmldb-table="myTable"></div>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, whose errors will be printed in this element.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-error-class` | Specifies the class name will be applied when error is shown.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldberror` | Triggered when an error returned especially after validation process.<br><br>`Event.detail.tableElementId` holds the table id that returned the error.<br>`Event.detail.errorText` holds the error text returned. |

#### Variables

This element has no HTMLDB variables.