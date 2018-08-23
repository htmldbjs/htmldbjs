### `HTMLDB.resetWriterLoop`

This method resets or initializes HTMLDB writer loop. HTMLDB periodically checks all `htmldb-table` elements if there is an insert/update and/or delete operation. If there is an insert/update and/or delete operation `HTMLDB.write` method is called for each `htmldb-table` element.

Please note that this method is used for inner operations, there is no need to call directly.

#### Description

```javascript
HTMLDB.resetWriterLoop()
```

#### Parameters

This method has no parameters.

#### Returns

This method returns the modified string.