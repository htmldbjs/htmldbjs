### `HTMLDB.extractFormToggleFields`

This method returns an array listing `htmldb-field` names that is used in `filter` string.

#### Description

```javascript
HTMLDB.extractFormToggleFields(filter, parent)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `filter` | Specifies the filter expression contains mustache templates.<br><br>`Accepts: String`<br>`Required` |
| `parent` | Specifies the container element whose fields will be explored.<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns an array listing `htmldb-field` names that is used in `filter` string.