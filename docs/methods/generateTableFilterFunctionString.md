### `HTMLDB.generateTableFilterFunctionString`

This method generates filter function body for the given `tableElement`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.generateTableFilterFunctionString(tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose filter function will be generated. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns generated function body.