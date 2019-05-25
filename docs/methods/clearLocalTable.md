### `HTMLDB.clearLocalTable`

This method clears all the records stored in the indexedDB object store for the given `tableElement`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.clearLocalTable(tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose indexedDB object stores will be cleared. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `omitReaderTable` | Specifies whether reader table will be omitted or not<br><br>`Accepts: Boolean`<br>`Optional` |
| `omitWriterTable` | Specifies whether writer table will be omitted or not<br><br>`Accepts: Boolean`<br>`Optional` |

#### Returns

This method returns nothing.