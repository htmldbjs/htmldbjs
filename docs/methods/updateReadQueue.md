### `HTMLDB.updateReadQueue`

This method adds `tableElement` and its child elements in the read queue.

#### Description

```javascript
HTMLDB.updateReadQueue(tableElement, skipProcess)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element that will be added to read queue. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `skipProcess` | Specifies whether `processReadQueue` call will be skipped or not<br><br>`Accepts: Boolean`<br>`Optional` |

#### Returns

This method returns nothing.