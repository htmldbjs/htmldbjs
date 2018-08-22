### `HTMLDB.checkIfIndexedDBTableExists`

This method checks indexedDB object store has been created for the given `tableElement` or not.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.checkIfIndexedDBTableExists(tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element will be checked. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns `true` if the indexedDB object store exists for the `tableElement`. Otherwise return `false`.