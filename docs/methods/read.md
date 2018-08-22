### `HTMLDB.read`

This method reads records from server/indexedDB or parent table and populates `htmldb-table` element specified by `tableElement`.

#### Description

```javascript
HTMLDB.read(tableElement, functionDone)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element will be read. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `functionDone`| Specifies the function to be called after completing read operation.<br><br>`Accepts: Function` |

#### Returns

This method returns `true` if the read operation has been successfully initiated, returns `false` otherwise.