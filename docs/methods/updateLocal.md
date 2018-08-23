### `HTMLDB.updateLocal`

This method updates indexedDB object store of the given `tableElement` with the given `object`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.updateLocal(tableElement, id, object, updateOnlyReaderTable)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the record will be updated locally. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `id` | Specifies `id` of the record to be modified.<br><br>`Accepts: String`<br>`Required` |
| `object` | Specifies the object to be updated.<br><br>`Accepts: Object`<br>`Required` |
| `updateOnlyReaderTable` | Specifies whether only reader table will be updated or not.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns `true` on success, and returns `false` on failure.