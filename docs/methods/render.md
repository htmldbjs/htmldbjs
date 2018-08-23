### `HTMLDB.render`

This method renders all related elements (eg. `htmldb-form`, `htmldb-section`, `htmldb-template`, `htmldb-pagination`) of `tableElement`.

#### Description

```javascript
HTMLDB.render(tableElement, functionDone)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose visible data elements (eg. `htmldb-section`, `htmldb-template`, `htmldb-form`) will be rendered. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `functionDone` | Specifies the function to be called after completing "render" operation.<br><br>`Accepts: Function` |

#### Returns

This method returns nothing.