### `HTMLDB.write`

This method writes records to server of the `htmldb-table` element specified by `tableElement`.

#### Description

```javascript
HTMLDB.write(tableElement, delayed, functionDone)
```

#### Parameters

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that contains the records will be written. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `delayed` | Specifies that "write" operation will be delayed or not. This parameter value important while updating large number of recods. If `delayed=true` "write" operation is not POST values to the server one by one.<br><br>`Default Value: ""`<br>`Optional` |
| `functionDone`| Specifies the function to be called after completing "write" operation.<br><br>`Accepts: Function`<br>`Optional` |

#### Returns

This method returns `false` on failure.