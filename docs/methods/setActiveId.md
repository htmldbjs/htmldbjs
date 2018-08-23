### `HTMLDB.setActiveId`

This method sets the active `id` of the given `tableElement`. HTMLDB uses active `id` values as a table cursor. When a table data retreived from the server, active `id` is set to the first `id` value. If an `htmldb-table` element value is set to another value, all related elements (`htmldb-table`, `htmldb-form`, `htmldb-template` and etc.) will be updated respectively.

#### Description

```javascript
HTMLDB.setActiveId(tableElement, id, silent)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose active id will be set. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `id` | Specifies the `id` value to be set.<br><br>`Accepts: String`<br>`Required` |
| `silent` | Specifies that after setting the active `id`, related elements will be updated or not. If `silent=true`, none of the related elements will be updated. If `silent=undefined` (not satisfied) or `silent=false`, all related elements will be updated.<br><br>`Accepts: Boolean`<br>`Optional` |

#### Returns

This method returns nothing.