### `HTMLDB.initializeHTMLDBEditButtons`

This method initializes `htmldb-button-edit` elements within `parent` related to `tableElement`.

#### Description

```javascript
HTMLDB.initializeHTMLDBEditButtons(parent, tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `parent` | Specifies the container element. If not specified, document.body is used for `parent` parameter.<br><br>`Accepts: DOM Element`<br>`Optional` |
| `tableElement` | Specifies the `htmldb-table` element that is related to the edit buttons will be initialized. If this parameter specified, only the edit buttons related to this `htmldb-table` element will be initialized. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Optional` |

#### Returns

This method returns nothing.