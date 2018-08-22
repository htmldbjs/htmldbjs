### `HTMLDB.convertRowToObject`

This method converts data, stored in the reader table, to a key-value associated JavaScript object.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.convertRowToObject(tableElement, row)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the `row` element. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `row` | Specifies the row element that holds data to be converted.<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns constructed JavaScript object.