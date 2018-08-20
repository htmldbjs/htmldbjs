### `htmldb-form`

A container for the `htmldb-field` elements, that automatically updated by `htmldb-table`.

#### Syntax

```html
<form id="myForm"
        name="myForm"
        method="post"
        class="htmldb-form"
        data-htmldb-table="myTable">

</form>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table of the form.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbreset` | Triggered when HTMLDB resets the htmldb-form form element. |

#### Variables

This element has no HTMLDB variables.