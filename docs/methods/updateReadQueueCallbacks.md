### `HTMLDB.updateReadQueueCallbacks`

This method adds a callback function for the `tableElement`.

#### Description

```javascript
HTMLDB.updateReadQueueCallbacks(tableElement, callbackFunction)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `callbackFunction` | Specifies the function will be called after reading `tableElement`.<br><br>`Accepts: Function`<br>`Required` |

#### Returns

This method returns nothing.