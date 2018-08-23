### `HTMLDB.validate`

This method validates the record specified by `object` to be inserted or updated in the `tableElement`.

#### Description

```javascript
HTMLDB.validate(tableElement, object, functionDone)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the records will be validated. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `object` | Specifies the object to be validated.<br><br>`Accepts: Object`<br>`Required` |
| `functionDone` | Specifies the function to be called after completing the "validate" operation.<br><br>`Accepts: Function` |

#### Returns

This method returns `false` on failure.

