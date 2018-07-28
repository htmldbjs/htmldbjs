### `htmldb-pagination`

A container element for easily navigating among the pages of `htmldb-table` element.

#### Syntax

```html
<ul class="htmldb-pagination"
        data-htmldb-table="myTable"
        data-htmldb-page-field="page"
        data-htmldb-page-count-field="pageCount"
        data-htmldb-refresh-table="myTable2"
        data-htmldb-table-defaults="">

    <li class="htmldb-pagination-template htmldb-pagination-previous">

        <button class="htmldb-button-page">Previous</button>

    </li>

    <li class="htmldb-pagination-template htmldb-pagination-next">

        <button class="htmldb-button-page">Next</button>

    </li>

    <li class="htmldb-pagination-template htmldb-pagination-default">

        <button class="htmldb-button-page">

            <span data-htmldb-content="{{page}}"></span>

        </button>

    </li>

    <li class="htmldb-pagination-template htmldb-pagination-active">

        <button class="htmldb-button-page">

            <span data-htmldb-content="{{page}}"></span>

        </button>

    </li>

    <li class="htmldb-pagination-template htmldb-pagination-hidden">

        <button class="htmldb-button-page" disabled="disabled">

            <span>...</span>

        </button>

    </li>

</ul>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies table, that holds the pagination configuration. When user clicks the a page in `htmldb-pagination`, pagination configuration specified by `data-htmldb-page-field` is saved to this table.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-refresh-table` | Specifies the table(s), that will refreshed after a page is clicked in `htmldb-pagination`  element. This attribute can hold more than one HTMLDB table seperating with comma `,` symbol.<br><br>`Default Value: ""` |
| `data-htmldb-page-field` | Specifies the field name that holds the current page index starting from `0`.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-page-count-field` | Specifies the field name that holds page count.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-page` | Specifies the current page index starting from `0`.<br><br>`Default Value: ""`<br>`Read-Only` |
| `data-htmldb-page-count` | Specifies the current page count.<br><br>`Default Value: ""`<br>`Read-Only` |
| `data-htmldb-table-defaults` | Specifies extra fields to be updated when a user clicks a page in `htmldb-pagination`. This attribute value must be in JSON format, thus specified between `'` single quotation marks. Because, double quotation marks are required for the definition of JSON object properties.<br><br>`Default Value: ""` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbrender` | Triggered when an htmldb-pagination element has been rendered. |
| `htmldbpageclick` | Triggered when a page element clicked within an htmldb-pagination element.<br><br>`Event.detail.page` holds the page index. |

#### Variables

| Variable Name | Description  |
| ---- | ---- |
| `page` | Gives the current page index starting from `0`.<br><br>`Read-Only` |
| `pageCount` | Gives the current page count.<br><br>`Read-Only` |