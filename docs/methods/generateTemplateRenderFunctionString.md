### `HTMLDB.generateTemplateRenderFunctionString`

This method generates function body for the templates for given `templateElement`, `tableElementId` and `targetElementId`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.generateTemplateRenderFunctionString(templateElement, tableElementId, targetElementId)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `templateElement` | Specifies the template element whose render function will be generated.<br><br>`Accepts: String`<br>`Required` |
| `tableElementId` | Specifies the `id` attribute value of the `htmldb-table` element that will be used as data source for the `templateElement`.<br><br>`Accepts: String`<br>`Required` |
| `targetElementId` | Specifies target element `id` attribute value. Additionally this attribute accepts mustache text notation.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns generated function body.