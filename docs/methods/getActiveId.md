### `HTMLDB.getActiveId`

This method returns the active `id` of the given `tableElement`. HTMLDB uses active `id` values as a table cursor. When a table data retreived from the server, active `id` is set to the first `id` value. If an `htmldb-table` element value is set to another value, all related elements (`htmldb-table`, `htmldb-form`, `htmldb-template` and etc.) will be updated respectively.

#### Description

```javascript
HTMLDB.getActiveId(tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose active id will be returned. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns the active `id` of the `tableElement`.