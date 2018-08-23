### `HTMLDB.initializeLocalTableRows`

This method reads data from indexedDB object store for the given `tableElement`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.initializeLocalTableRows(tableElement, tablePrefix, result)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the table rows and data that will be stored in browser's indexedDB database. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `tablePrefix` | Specifies table prefix (eg. "reader" or "writer").<br><br>`Accepts: String`<br>`Required` |
| `result` | Specifies the result object from indexedDB object store.<br><br>`Accepts: IndexedDB Result`<br>`Required` |

#### Returns

This method returns nothing.