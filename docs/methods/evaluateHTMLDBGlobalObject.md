### `HTMLDB.evaluateHTMLDBGlobalObject`

This method calculates the values and replaces mustache templates (between `{{` and `}}`) of the global objects (eg. $URL) and returns the modified string.

#### Description

```javascript
HTMLDB.evaluateHTMLDBGlobalObject(globalObject, parameter)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `globalObject` | Specifies the global object as string.<br><br>`Accepts: String`<br>`Required` |
| `parameter` | Specifies the global object parameter as string.<br><br>`Accepts: String`<br>`Optional` |

#### Returns

This method returns the modified string.