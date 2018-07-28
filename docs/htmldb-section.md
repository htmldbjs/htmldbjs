### `htmldb-section`

A container for the elements, that automatically rendered by the related `htmldb-table`.

#### Syntax

```html
<div class="htmldb-section" data-htmldb-table="myTable">
    
    <p>First Name:</p>
    
    <p data-htmldb-content="{{firstname}}"></p>
    
    <p>Last Name:</p>
    
    <p data-htmldb-content="{{lastname}}"></p>
    
    <p>E-mail Address:</p>
    
    <p data-htmldb-content="{{email}}"></p>

</div>
```

#### Attributes
| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, that will automatically update the mustache text templates in the `htmldb-section` element.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-content` | Specifies the mustache text template that will be copied into the inner HTML of the element in the `htmldb-section` element.<br><br>`Default Value: ""` |

#### Events

This element has no HTMLDB events.

#### Variables

This element has no HTMLDB variables.