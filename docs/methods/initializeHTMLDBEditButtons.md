### `HTMLDB.initializeHTMLDBEditButtons`

This method adds zeros at the beginning of a given `text` to construct a string with the length of `digitCount`.

#### Description

```javascript
HTMLDB.initializeHTMLDBEditButtons(parent, tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `parent` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |
| `tableElement` | Specifies the `htmldb-table` element that is related to the edit buttons to be initialized. If this parameter specified, only the edit buttons related to this `htmldb-table` element will be initialized. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Optional` |

#### Returns

This method returns the modified string.