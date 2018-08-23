### `HTMLDB.update`

This method updates the record specified by `id` in the `tableElement`.

#### Description

```javascript
HTMLDB.update(tableElement, id, object, className)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the record will be updated. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `id` | Specifies the `id` of the record to be updated.<br><br>`Accepts: String`<br>`Required` |
| `object` | Specifies the object that contains new values.<br><br>`Accepts: Object`<br>`Required` |
| `className` | Specifies the extra class name will be used to mark updated record.<br><br>`Accepts: String`<br>`Optional` |

#### Returns

This method returns nothing.