### `HTMLDB.getMaxPriority`

This method gets maximum priority value of the given `tableIds`. HTMLDB uses an integer value starting from zero to determine the load order of the `htmldb-table` elements within an HTML page. This method calculates the maximum priority value of the given `tableIds`.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.getMaxPriority(tableIds)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableIds` | Specifies table `id`s in an array.<br><br>`Accepts: Array`<br>`Required` |

#### Returns

This method returns the priority value.