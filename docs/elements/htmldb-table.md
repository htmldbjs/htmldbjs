### `htmldb-table`

Data source element that retrieves and stores data from the server. Also, it validates and posts data to the server.

#### Syntax

```html
<div id="myFirstTable"
        class="htmldb-table"
        data-htmldb-read-url="myfirsttable/read"
        data-htmldb-validate-url="myfirsttable/validate"
        data-htmldb-write-url="myfirsttable/write"></div>
```

#### Attributes

| Attribute Name | Description |
| ---- | ---- |
| `data-htmldb-filter` | Specifies filter expression will be used while reading data from a parent HTMLDB table instance. This attribute is used with `data-htmldb-table`. Additionally, this attribute accepts mustache text notation.<br><br>`Default Value: ""`<br> |
| `data-htmldb-loader` | Specifies the loader element id that will be shown on all read, validate and write operations.<br><br>`Default Value: ""` |
| `data-htmldb-local` | Specifies whether HTMLDB table instance will store data in browser's local storage (IndexedDB) or not. Local HTMLDB table instances are not automatically retreive data from the server or post data to the server. It stores all the data in IndexedDB. Local HTMLDB table instances use `HTMLDB` as database name and HTMLDB table element `id` for object store name. Local HTMLDB table data can be accessible from all pages in the same domain.<br><br>`Default Value: "0"` |
| `data-htmldb-priority` | Specifies the loading priority of the HTMLDB table.<br><br>`Default Value: "0"` |
| `data-htmldb-read-loader` | Specifies the loader element id that will be shown only on read operations.<br><br>`Default Value: ""` |
| `data-htmldb-read-url` | Specifies the URL of the data requested from the server.<br><br>`Default Value: ""` |
| `data-htmldb-read-only` | Specifies that HTMLDB table instance is read-only or not.<br><br>`Default Value: "0"` |
| `data-htmldb-redirect` | Specifies the redirect URL after posting data to the server.<br><br>`Default Value: ""` |
| `data-htmldb-refresh-table` | Specifies the table(s), that will refreshed after saving. This attribute can hold more than one HTMLDB table seperating with comma `,` symbol.<br><br>`Default Value: ""` |
| `data-htmldb-table` | Specifies the parent HTMLDB table `id`. This attribute is used with `data-htmldb-table`.<br><br>`Default Value: ""` |
| `data-htmldb-validate-loader` | Specifies the loader element id that will be shown only on validate operations.<br><br>`Default Value: ""` |
| `data-htmldb-validate-url` | Specifies the URL that simulates posting data to the server for validation.<br><br>`Default Value: ""` |
| `data-htmldb-write-loader` | Specifies the loader element id that will be shown only on write operations.<br><br>`Default Value: ""` |
| `data-htmldb-form` | Specifies the target form that will be updated after read operations.<br><br>`Default Value: ""` |
| `data-htmldb-loading` | Specifies the table is loading or not.<br><br>`Default Value: ""`<br>`Read-Only` |
| `data-htmldb-method` | Specifies the HTTP request method on write operations.<br><br>`Default Value: "post"` |
| `data-htmldb-active-id` | Specifies the current id (like cursor) of the table. After loading/refreshing, active id is automatically reset to first id in the list.<br><br>`Default Value: ""`<br>`Read-Only` |
| `data-htmldb-read-incremental` | Specifies that read operations will be incremental or not. In incremental read operations, the table records are not cleared. All read operations are added at the end of the list.<br><br>`Default Value: "0"` |
| `data-htmldb-write-url` | Specifies the data post URL.<br><br>`Default Value: ""` |
| `data-htmldb-write-only` | Specifies that HTMLDB table instance is write-only or not.<br><br>`Default Value: "0"` |
| `id` | Specifies the name of the HTMLDB table.<br><br>`Default Value: ""`<br>`Required`<br>`Unique` |

#### Filter Syntax

HTMLDB proposes an easy way to specify filters as an attribute value. `/` symbol is used to seperate operators and operands. 

Following examples show the usage of filters:

- `"deleted/eq/0/and/enabled/eq/1"`
- `"customer_id/gt/0/or/supplier_id/gt/0"`
- `"name/isnot/''"`
- `"category/in/1,3,4"`
- `"category/is/{{category_id}}"`
- `"invoice_date/lt/{{:new Date().getTime();}}"`

#### Filter Operators

- `is` or `eq` means "equal to".
- `isnot` or `neq` means "not equal to".
- `gt` means "greater than".
- `gte` means "greater than or equal to".
- `lt` means "less than".
- `lte` means "less than or equal to".
- `in` means "in comma `,` seperated values".
- `notin` means "not in comma `,` seperated values".

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbbeforeredirect` | Triggered before redirect operation after `write` process performed.<br><br>`Event.detail.redirectURL` holds redirect URL. |
| `htmldberror` | Triggered when an error returned especially after validation process.<br><br>`Event.detail.errorText` holds the error text returned. |
| `htmldbmessage` | Triggered when a message returned especially after validation process.<br><br>`Event.detail.messageText` holds the message text returned. |
| `htmldbread` | Triggered when table is readed.<br><br>`Event.detail.remote` holds boolean value for the "read" events from server.<br>`Event.detail.local` holds boolean value for the "read" events from browser's local storage (indexedDB). |
| `htmldbreadlocal` | Triggered when table is readed locally.<br><br>`Event.detail.remote` holds boolean value for the "read" events from server.<br>`Event.detail.local` holds boolean value for the "read" events from browser's local storage (indexedDB). |
| `htmldbreadremote` | Triggered when table is readed remotely.<br><br>`Event.detail.remote` holds boolean value for the "read" events from server.<br>`Event.detail.local` holds boolean value for the "read" events from browser's local storage (indexedDB). |

#### Variables

All the columns in the table, can be considered as HTMLDB variable.