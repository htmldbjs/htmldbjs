### `htmldb-template`

A container element for the templates, that are automatically rendered by related `htmldb-table`.

#### Syntax

```html
<table id="myTemplateTarget"></table>

<script type="text/html"
        id="myTemplate"
        class="htmldb-template"
        data-htmldb-table="myTable"
        data-htmldb-template-target="myTemplateTarget">

        <tr class="tr{{id}}" data-object-id="{{id}}">

            <td>{{id}}</td>

            <td>{{company_name}}</td>

            <td>{{company_type}}</td>

        </tr>

</script>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, that will be used to render this template.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-template-target` | Specifies the target element id, which will be populated after rendering this template. Additionally this attribute accepts table fields and element variables in mustache template notation.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-filter` | Specifies filter expression will be used while reading data from a parent HTMLDB table instance. Additionally, this attribute accepts mustache text notation.<br><br>`Default Value: ""`. |

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

#### Special Template Variables

- `__index__` is replaced with current index value.
- `__count__` is replaced with list count.
- `__is_first__` is replaced with `1` if the current record is the first item of the list, otherwise replaced with `0`.
- `__is_not_first__` is replaced with `1` if the current record IS NOT the first item of the list, otherwise replaced with `0`.
- `__is_last__` is replaced with `1` if the current record is the last item of the list, otherwise replaced with `0`.
- `__is_not_last__` is replaced with `1` if the current record IS NOT the last item of the list, otherwise replaced with `0`.
- `__is_even__` is replaced with `1` if the current is even, otherwise replaced with `0`.
- `__is_odd__` is replaced with `1` if the current is odd, otherwise replaced with `0`.

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbrender` | Triggered when an htmldb-template element has been rendered.<br><br>`Event.detail.targets` holds the list of target elements rendered. |

#### Variables

This element has no HTMLDB variables.