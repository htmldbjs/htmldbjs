### `HTMLDB.validateRemote`

This method validates the record(s) remotely specified by `objectArray` to be inserted or updated in the `tableElement`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.validateRemote(tableElement, objectArray, functionDone)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the records will be validated remotely. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `objectArray` | Specifies the objects to be validated.<br><br>`Accepts: Object Array`<br>`Required` |
| `functionDone` | Specifies the function to be called after completing "validate" operation.<br><br>`Accepts: Function` |

#### Returns

This method returns `false` on failure.