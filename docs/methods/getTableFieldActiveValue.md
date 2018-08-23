### `HTMLDB.getTableFieldActiveValue`

This method gets the current value of the `column` of the given `tableElement`.

#### Description

```javascript
HTMLDB.getTableFieldActiveValue(tableElement, column)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the data will be returned. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `column` | Specifies the column name.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns the current value of the `column` in the `tableElement`.