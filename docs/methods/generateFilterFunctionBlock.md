### `HTMLDB.generateFilterFunctionBlock`

This method generates filter function body for the given `filter` and `parent`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.generateFilterFunctionBlock(filter, parent)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `filter` | Specifies the filter text (in format "deleted/eq/0/and/enabled/eq/1") that will be used to generate function body.<br><br>`Accepts: String`<br>`Required` |
| `parent` | Specifies the parent element.<br><br>`Accepts: DOM Element`<br>`Required` |

#### Returns

This method returns generated function body according to the `filter` value.