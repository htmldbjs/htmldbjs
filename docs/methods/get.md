### `HTMLDB.get`

This method gets the record specified by `id` from `tableElement`.

#### Description

```javascript
HTMLDB.get(tableElement, id)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the record will be get. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `id` | Specifies the id of the record to be retreived.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns the record in an JavaScript object specified by `id`.