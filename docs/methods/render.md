### `HTMLDB.render`

This method adds zeros at the beginning of a given `text` to construct a string with the length of `digitCount`.

#### Description

```javascript
HTMLDB.render(tableElement, functionDone)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose visible data elements (eg. `htmldb-section`, `htmldb-template`, `htmldb-form`) to be rendered. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `functionDone` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns the modified string.