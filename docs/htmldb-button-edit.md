### `htmldb-button-edit`

An action button is used for editing a specific record. When `htmldb-button-edit` button is clicked `htmldb-table` element's active id is set to the specified record. Additionally, all related form fields are populated with the values of the record.

#### Syntax

```html
<button class="htmldb-button-edit"
        type="button"
        data-htmldb-edit-id="1"
        data-htmldb-table="myTable"
        data-htmldb-form="myForm">Edit Record</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies parent table, that holds the record to be edited.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-form` | Specifies the form, that will be populated with the record in `data-htmldb-table` table specified by `data-htmldb-edit-id` value.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-edit-id` | Specified the unique id value of the record to be edited.<br><br>`Default Value: ""`<br>`Required` |

#### Events

This element has no HTMLDB events.

#### Variables

This element has no HTMLDB variables.