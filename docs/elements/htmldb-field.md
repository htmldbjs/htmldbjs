### `htmldb-field`

An input element, that holds the current values of the `htmldb-form` fields.

#### Syntax

```html
<form id="myForm"
        name="myForm"
        method="post"
        class="htmldb-form"
        data-htmldb-table="myTable">

    <input id="name"
            name="name"
            type="text"
            value=""
            class="htmldb-field"
            data-htmldb-field="company_name">

</form>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-field` | Specifies the field name. The parent table name is specified in the container form.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-value` | Specifies the field value in mustache text notation (e.g. `{{id}}`, `{{name}}`).<br><br>`Default Value: Field name (e.g. {{name}})` |
| `data-htmldb-reset-value` | Specifies the value of the element, after container form is reset. This attribute accepts mustache text notation.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsetvalue` | Triggered when HTMLDB sets the htmldb-field input value.<br><br>`Event.detail.value` holds the value has been set. |
| `htmldbgetvalue` | Triggered when HTMLDB is about to get the htmldb-field input value. |
| `htmldbreset` | Triggered when HTMLDB resets the htmldb-field element. |

#### Variables

This element has no HTMLDB variables.