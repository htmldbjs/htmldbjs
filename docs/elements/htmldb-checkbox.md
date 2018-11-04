### `htmldb-checkbox`

A checkbox input item in `htmldb-checkbox-group`, that enables to select/update/delete multiple records. Additionally, there is a special checkbox element `htmldb-checkbox-all` makes it possible to check all checkbox elements within a `htmldb-checkbox-group`.

#### Syntax

```html
        <input id="checkboxAll"
                name="checkboxAll"
                type="checkbox"
                class="htmldb-checkbox-all"
                data-htmldb-checkbox-id="" />

        <input id="checkbox1"
                name="checkbox1"
                type="checkbox"
                class="htmldb-checkbox"
                data-htmldb-checkbox-id="1"
                data-htmldb-checkbox-defaults='{"enabled":1}' />
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-checkbox-id` | Specifies the unique identifier of the checkbox item according to `data-htmldb-table` attribute of the container `htmldb-checkbox-group`. <br><br>`Default Value: "0"` |
| `data-htmldb-checkbox-defaults`| Specifies record defaults in JSON format. This attribute value must be specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""` |

#### Events

This element has no HTMLDB events.

#### Variables

This element has no HTMLDB variables.