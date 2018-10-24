### `HTMLDB.exploreHTMLDBElement`

This method finds container HTMLDB element with the given `child` and `className`.

#### Description

```javascript
HTMLDB.exploreHTMLDBElement(child, className)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `child` | Specifies the `child` whose container will be explored.<br><br>`Accepts: DOM Element`<br>`Required` |
| `className` | Specifies the CSS class name (e.g. `htmldb-table`, `htmldb-form`) to be explored.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns found container element or `false` in failure.