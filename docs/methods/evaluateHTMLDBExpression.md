### `HTMLDB.evaluateHTMLDBExpression`

This method calculates the values and replaces mustache templates (between `{{` and `}}`) and returns the modified string.

#### Description

```javascript
HTMLDB.evaluateHTMLDBExpression(expression, parent)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `expression` | Specifies the expression contains mustache templates.<br><br>`Accepts: String`<br>`Required` |
| `parent` | Specifies the parent `htmldb-table` or `htmldb-form`. If not specified mustache templates are calculated based on global values.<br><br>`Accepts: DOM Element`<br>`Optional` |

#### Returns

This method returns the modified string.