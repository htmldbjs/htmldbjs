### `HTMLDB.convertListRowToObject`

This method converts data, retreived from the server, to a key-value associated JavaScript object.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.convertListRowToObject(listRow, columns)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `listRow` | Specifies the data retreived from the server.<br><br>`Accepts: Object`<br>`Required` |
| `columns` | Specifies the columns that will be used to extract values from `listRow`.<br><br>`Accepts: Object`<br>`Required` |

#### Returns

This method returns constructed JavaScript object.