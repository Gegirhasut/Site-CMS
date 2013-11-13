{if isset($fields.manyToMany) && $fields.manyToMany.Type.type eq 'autocomplete'}
    <tr>
        <td>
            <div style="float: left;">
                <label for="object">{$fields.manyToMany.Type.title}</label>
                <input id="object" />
            </div>
            <span class="addButton" onclick="addObject('{$object[$fields.identity]}', '{$fields.manyToMany.Type.link_object}', '{$fields.manyToMany.Type.join_object}', '{$fields.manyToMany.Type.name}')"></span>
            <div style="clear: both;" />

            <br/>
            <div id="users_objects">
            </div>
        </td>
    </tr>

    <script type="text/javascript" src="/js/app/subjects.js"></script>

    <script language="javascript">
        var availableObjects = [
            {foreach from=$fields.manyToMany.Type.all_value item=object name=objects}
            "{$object[$fields.manyToMany.Type.join_field_name]}"{if !$smarty.foreach.objects.last},
            {/if}
            {/foreach}
        ];

        {literal}
        $(function() {
            $( "#object" ).autocomplete({
                source: availableObjects
            });
        });

        {/literal}

        {foreach from=$fields.manyToMany.Type.value item=uo}
        addObjectElement({$uo[$join_identity]}, '{$uo[$fields.manyToMany.Type.join_field_name]}', '{$fields.manyToMany.Type.link_object}');
        {/foreach}
    </script>
{/if}