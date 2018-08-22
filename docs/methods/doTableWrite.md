### `HTMLDB.doTableWrite`

This method adds zeros at the beginning of a given `text` to construct a string with the length of `digitCount`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.doTableWrite(tableElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the written records. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns the modified string.