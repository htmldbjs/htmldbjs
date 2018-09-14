### `htmldb-button-sort`

An action button is used for updating the sorting preferences.

#### Syntax

```html
<button type="button"
        class="htmldb-button-sort"
        data-htmldb-table="myTable"
        data-htmldb-sort-field="sortingColumn"
        data-htmldb-sort-value="0"
        data-htmldb-parent-apply-loading-class="0"
        data-htmldb-direction-field="sortingASC"
        data-htmldb-refresh-table="myTable2,myTable3"
        data-htmldb-table-defaults='{"page":0}'>Sort Column</button>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies table, that holds the sorting configuration. When user clicks the `htmldb-button-sort` button, sorting configuration specified by `data-htmldb-sort-field`, `data-htmldb-sort-value` and `data-htmldb-direction-field` is saved to this table.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-parent-apply-loading-class` | Specifies whether `htmldb-loading` will be applied to parent element or not.<br><br>`Default Value: "1"` |
| `data-htmldb-sort-field` | Specifies the sort field in the `data-htmldb-table` table.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-sort-value` | Specifies the sort field value, that holds the column id, index or name to be saved when the user clicks this button.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-direction-field` | Specifies the sort direction (Ascending or Descending) field in the `data-htmldb-table` table. Value of this field is automatically determined by the current state of this button. Additionally, an extra class is added according to the state of this button. If the sorting direction is ascending, `htmldb-sorting-asc` class is added. If the sorting direction is descending, `htmldb-sorting-desc` class is added.<br><br>`Default Value: ""`<br>`Required` |
| `data-htmldb-refresh-table` | Specifies the table(s), that will refreshed after sorting configuration is saved. This attribute can hold more than one HTMLDB table seperating with comma `,` symbol.<br><br>`Default Value: ""` |
| `data-htmldb-sorting-asc` | Specifies the current sorting direction. If the sorting direction is ascending, the value of this attribute is `1`, otherwise the value of this attribute is `0`.<br><br>`Default Value: "0"`<br>`Read-Only` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbsort` | Triggered when an htmldb-button-sort button clicked. |

#### Variables

This element has no HTMLDB variables.