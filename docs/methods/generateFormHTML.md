### `HTMLDB.generateFormHTML`

This method generates `FORM` content for posting values to the server for the given `tableElement` and `row`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.generateFormHTML(tableElement, iframeFormGUID, row)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the `row` element. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `iframeFormGUID` | Specifies the unique id for the `FORM`.<br><br>`Accepts: String`<br>`Required` |
| `row` | Specifies the row element whose `FORM` will be generated.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns generated `FORM` content.