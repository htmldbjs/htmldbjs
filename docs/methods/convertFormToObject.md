### `HTMLDB.convertFormToObject`

This method converts `htmldb-field` elements within the `form` to a key-value associated JavaScript object.

#### Description

```javascript
HTMLDB.convertFormToObject(form, defaultObject)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `form` | Specifies the `htmldb-form` element, that contains `htmldb-field` elements, will be converted.<br><br>`Accepts: DOM Element`<br>`Required` |
| `defaultObject` | Specifies the default `htmldb-field` values as a JavaScript key-value associated object.<br><br>`Accepts: Object`<br>`Optional` |

#### Returns

This method returns constructed JavaScript object based on `htmldb-field` element values.