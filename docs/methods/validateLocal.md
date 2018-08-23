### `HTMLDB.validateLocal`

This method validates the record locally specified by `object` to be inserted or updated in the `tableElement`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.validateLocal(tableElement, object, functionDone)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the records will be validated locally. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `object` | Specifies the object to be validated.<br><br>`Accepts: Object`<br>`Required` |
| `functionDone` | Specifies the function to be called after completing "validate" operation.<br><br>`Accepts: Function` |

#### Returns

This method returns nothing.