### `HTMLDB.clearReaderTable`

This method clears all the records stored in the reader table within the given `tableElement`.

Please note that this method is used for inner operations, there is no need to call directly.


#### Description

```javascript
HTMLDB.clearReaderTable(tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose readers (a container for data read from the server or source table) will be cleared. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns nothing.