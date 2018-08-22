### `HTMLDB.canWriteTable`

This method checks whether an update or insert operation is made or not. All the records that has been updated and inserted stored in a different table called writer tables.

#### Description

```javascript
HTMLDB.canWriteTable(tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element will be checked. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns `true` if at least one record inserted or updated within the given `tableElement`. Otherwise returns `false`.