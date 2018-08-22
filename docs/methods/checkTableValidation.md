### `HTMLDB.checkTableValidation`

This method validates the `htmldb-table` element given with `tableElement` for the given `object` using `htmldb-table-validation` element with the given `validationElement`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.checkTableValidation(tableElement, object, validationElement)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element will be checked. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `object` | Specifies the object that will be validated.<br><br>`Accepts: Object`<br>`Required` |
| `validationElement` | Specifies the `htmldb-table-validation` element will be used for validation.<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns `true` if the `object` is validated with the given `validationElement`. Otherwise returns `false`.