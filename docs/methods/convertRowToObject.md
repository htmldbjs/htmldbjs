### `HTMLDB.convertRowToObject`

This method adds zeros at the beginning of a given `text` to construct a string with the length of `digitCount`.

#### Description

```javascript
HTMLDB.convertRowToObject(tableElement, row)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the `row` element. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `row` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns the modified string.