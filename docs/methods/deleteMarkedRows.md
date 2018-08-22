### `HTMLDB.deleteMarkedRows`

This method deletes the rows from the `parent` that contains the class specified by `className`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.deleteMarkedRows(parent, className)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `parent` | Specifies the element whose rows will be deleted.<br><br>`Accepts: DOM Element`<br>`Required` |
| `className` | Specifies the class name will be used to choose rows to be deleted.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns nothing.