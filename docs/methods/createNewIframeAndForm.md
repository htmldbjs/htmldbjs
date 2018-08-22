### `HTMLDB.createNewIframeAndForm`

This method creates new HTMLDB `IFRAME` (for GET operations) and `FORM` (for POST operations) for the specific `tableElement`. For each GET and POST operation HTMLDB creates new instances of `IFRAME` and `FORM` elements. This makes it possible to make multiple GET/POST operations on a single `htmldb-table` element.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.createNewIframeAndForm(tableElement, guid)
```

#### Parameters

| Parameter Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `tableElement` | Specifies the `htmldb-table` element. This parameter accepts any DOM element from `document.getElementById` or `HTMLDB.e`<br><br>`Accepts: DOM Element`<br>`Required` |
| `guid` | Specifies the unique identifier will be used while creating the new `IFRAME` and `FORM` instances.<br><br>`Accepts: String`<br>`Required` |

#### Returns

This method returns nothing.