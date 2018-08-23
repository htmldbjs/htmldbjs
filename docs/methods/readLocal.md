### `HTMLDB.readLocal`

This method reads records from related indexedDB object store and populates `htmldb-table` element specified by `tableElement`.

#### Description

```javascript
HTMLDB.readLocal(tableElement, functionDone)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element will be read locally from the corresponding indexedDB object store. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `functionDone` | Specifies the function to be called after completing "read" operation.<br><br>`Accepts: Function` |

#### Returns

This method returns `true` if local table succesfully read, returns `false` if an error occurs.