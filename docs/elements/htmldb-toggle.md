
### `htmldb-toggle`

A special container for the form fields that automatically displayed or hided for a certain condition.

#### Syntax

```html
<div id="myContainer"
        class="htmldb-toggle"
        data-htmldb-filter="company_type/eq/1">

    <p>Company Type: 1</p>

</div>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-filter` | Specifies the condition according to the values of the container form that make this element visible. Additionally, this attribute accepts mustache text notation.<br><br>`Default Value: ""`<br>`Required` |
 
#### Filter Syntax

HTMLDB proposes an easy way to specify filters as an attribute value. `/` symbol is used to seperate operators and operands. 

Following examples show the usage of filters:

- `"deleted/eq/0/and/enabled/eq/1"`
- `"customer_id/gt/0/or/supplier_id/gt/0"`
- `"name/isnot/''"`
- `"category/in/1,3,4"`
- `"category/is/{{category_id}}"`
- `"invoice_date/lt/{{:new Date().getTime();}}"`

#### Filter Operators

- `is` or `eq` means "equal to".
- `isnot` or `neq` means "not equal to".
- `gt` means "greater than".
- `gte` means "greater than or equal to".
- `lt` means "less than".
- `lte` means "less than or equal to".
- `in` means "in comma `,` seperated values".
- `notin` means "not in comma `,` seperated values".

#### Events

This element has no HTMLDB events.

#### Variables

This element has no HTMLDB variables.