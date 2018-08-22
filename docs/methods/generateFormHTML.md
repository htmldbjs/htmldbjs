### `HTMLDB.generateFormHTML`

This method adds zeros at the beginning of a given `text` to construct a string with the length of `digitCount`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.generateFormHTML(tableElement, iframeFormGUID, row)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the `row` element. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `iframeFormGUID` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |
| `row` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns the modified string.