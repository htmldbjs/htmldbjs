### `htmldb-checkbox-group`

A container element for checkbox inputs. `htmldb-checkbox-group` makes it possible to select/update/delete multiple records.

#### Syntax

```html
<ul id="ulCheckboxGroup1" class="htmldb-checkbox-group" data-htmldb-table="myTable">

    <li>

        <input id="checkboxAll"
                name="checkboxAll"
                type="checkbox"
                class="htmldb-checkbox-all"
                data-htmldb-checkbox-id="" />

    </li>
    
    <li>

        <input id="checkbox1"
                name="checkbox1"
                type="checkbox"
                class="htmldb-checkbox"
                data-htmldb-checkbox-id="1" />
    
    </li>
    
    <li>
    
        <input id="checkbox2"
                name="checkbox2"
                type="checkbox"
                class="htmldb-checkbox"
                data-htmldb-checkbox-id="2" />
    
    </li>
    
    <li>
    
        <input id="checkbox3"
                name="checkbox3"
                type="checkbox"
                class="htmldb-checkbox"
                data-htmldb-checkbox-id="3" />
    
    </li>

</ul>
```

#### Attributes

| Attribute Name             | Description                               |
| -------------------------- | ----------------------------------------- |
| `data-htmldb-table` | Specifies the parent table. <br><br>`Default Value: ""`<br>`Required` |
| `id` | Specifies the unique identifier of the checkbox group. <br><br>`Default Value: ""`<br>`Required`<br>`Unique` |

#### Events

| Event Name | Description  |
| ---- | ---- |
| `htmldbclick` | Triggered when a checkbox in the checkbox group is clicked. |

#### Variables

| Variable Name | Description  |
| ---- | ---- |
| `checkedCount` | Gives the checked checkbox count in the checkbox group.<br><br>`Read-Only` |
| `checkboxCount` | Gives the total checkbox count in the checkbox group.<br><br>`Read-Only` |