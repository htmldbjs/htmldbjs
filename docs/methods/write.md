### `HTMLDB.initialize`

An action button is used for adding a new record to the specified table. When `htmldb-button-add` button is clicked related forms are reset.

#### Definition

```javascript
HTMLDB.initialize(tableElementId, functionDone)
```

#### Parameters

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElementId` | Specifies parent form, that new record will be entered.<br><br>`Default Value: ""`<br>`Required` |
| `functionDone`| Specifies new record defaults in JSON format. This attribute value must be specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""` |

#### Returns

