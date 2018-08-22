### `HTMLDB.evaluateHTMLDBExpressionWithObject`

This method calculates the values and replaces mustache templates (between `{{` and `}}`) based on given `object` and returns the modified string.

#### Description

```javascript
HTMLDB.evaluateHTMLDBExpressionWithObject(expression, object)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `expression` | Specifies the expression contains mustache templates.<br><br>`Accepts: String`<br>`Required` |
| `object` | Specifies the key-value associated JavaScript object that will be used as a source while calculating the values of mustache templates.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns the modified string.