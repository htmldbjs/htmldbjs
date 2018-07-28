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
| `data-htmldb-filter` | Specifies filter expression will be used while reading data from a parent HTMLDB table instance. <br><br>`Default Value: ""`. |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbrender` | Triggered when an htmldb-template element has been rendered. |

#### Variables

This element has no HTMLDB variables.