### `HTMLDB.generateTemplateRenderFunctionString`

This method adds zeros at the beginning of a given `text` to construct a string with the length of `digitCount`.

#### Description

```javascript
HTMLDB.generateTemplateRenderFunctionString(templateElement, tableElementId, targetElementId)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `templateElement` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |
| `tableElementId` | Specifies the `id` attribute value of the `htmldb-table` element that will be used as data source for the `templateElement`.<br><br>`Accepts: String`<br>`Required` |
| `targetElementId` | Specifies the text to be modified.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns the modified string.