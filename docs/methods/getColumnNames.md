### `HTMLDB.getColumnNames`

This method returns columns names in an array for the given `tableElement`.

#### Description

```javascript
HTMLDB.getColumnNames(tableElement, sortColumns)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the columns will be returned. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `sortColumns` | Specifies whether columns names retreived will be sorted alphabetically or not.<br><br>`Accepts: Boolean`<br>`Optional` |

#### Returns

This method returns column names in an array.