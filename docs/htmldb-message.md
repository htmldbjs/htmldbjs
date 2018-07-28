### `htmldb-message`

A container element for the messages.

#### Syntax

```html
<div class="htmldb-message"
        data-htmldb-table="myTable"></div>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table, whose messages will be printed in this element.<br><br>`Default Value: ""`<br>`Required` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbmessage` | Triggered when a message returned especially after validation process.<br><br>`Event.detail.tableElementId` holds the table id that returned the message.<br>`Event.detail.messageText` holds the message text returned. |

#### Variables

This element has no HTMLDB variables.