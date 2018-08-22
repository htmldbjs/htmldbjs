### `HTMLDB.delete`

This method deletes the record specified by `id` from `tableElement`.

#### Description

```javascript
HTMLDB.delete(tableElement, id, className)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that holds the record will be deleted. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `id` | Specifies the `id` value of the record that will be deleted.<br><br>`Accepts: String`<br>`Required` |
| `className` | Specifies the extra class name will be used to mark deleted record.<br><br>`Accepts: String`<br>`Optional` |

#### Returns

This method returns nothing.