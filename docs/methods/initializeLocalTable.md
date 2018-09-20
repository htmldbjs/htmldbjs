### `HTMLDB.initializeLocalTable`

This method initializes indexedDB object stores for the given `tableElement`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.initializeLocalTable(tableElement, functionDone)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the tables and data that will be stored in browser's indexedDB database. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `functionDone` | Specifies the callback function will be called after initialization process.<br><br>`Accepts: Function`<br>`Required` |

#### Returns

This method returns nothing.