### `HTMLDB.generateTDHTML`

This method generates `TR` content for the given `tableElement` and `object`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.generateTDHTML(tableElement, prefix, object, id)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element whose table row contents will be generated. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `prefix` | Specifies prefix "reader" or "writer".<br><br>`Accepts: String`<br>`Required` |
| `object` | Specifies the object whose HTML code will be generated.<br><br>`Accepts: Object`<br>`Required` |
| `id` | Specifies the id of the `TR`.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns generated `TR` content.