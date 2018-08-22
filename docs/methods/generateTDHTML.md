### `HTMLDB.generateTDHTML`

This method adds zeros at the beginning of a given `text` to construct a string with the length of `digitCount`.

#### Description

```javascript
HTMLDB.generateTDHTML(tableElement, prefix, object, id)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose table row contents will be generated. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `prefix` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |
| `object` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |
| `id` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns the modified string.