### `HTMLDB.e`

This method is an alias for `document.getElementById`.

#### Description

```javascript
HTMLDB.e(elementId)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `elementId` | `htmldb-table` element to be read. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Required` |
| `functionDone`| Specifies the function to be called after completing read operation. |

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `elementId` | Element id to be used to call document.getElementById function.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns DOM element if the element specified by `elementId` is found, returns `undefined` otherwise.