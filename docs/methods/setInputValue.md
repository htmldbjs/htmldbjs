### `HTMLDB.setInputValue`

This method assigns the `value` to the given `input`.

#### Description

```javascript
HTMLDB.setInputValue(input, value, silent)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `input` | Specifies the input whose value will be modified.<br><br>`Accepts: DOM Element`<br>`Required` |
| `value` | Specifies the value to be assigned.<br><br>`Accepts: String`<br>`Required` |
| `silent` | Specifies that after setting the input value, related elements will be toggled or not. If `silent=true`, none of the related elements will be toggled. If `silent=undefined` (not satisfied) or `silent=false`, all related elements will be toggled.<br><br>`Accepts: Boolean`<br>`Optional` |

#### Returns

This method returns nothing.