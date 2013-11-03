<input type="text" name="filter_{$name}" id="filter_{$name}" onkeyup="fill{$name}()" value="{$field.values}" autocomplete="off"/>
<input type="hidden" name="{$name}" id="{$name}" value="{$object[$name]}" />

<script>
    var availableObjects{$name} = [];
    var availableObjectsData{$name} = [];

    function fill{$name}() {ldelim}
        var search = $( "#filter_{$name}").val();
        if (search != '') {ldelim}
            $.ajax({ldelim}
                dataType: "json",
                url: '/admin/api/{$field.source}/' + search,
                success: parseJson{$name}
                {rdelim});
            {rdelim} else {ldelim}
                $( "#{$name}").val('');
            {rdelim}
        {rdelim}

    function parseJson{$name}(data) {ldelim}
        availableObjects{$name} = [];
        availableObjectsData{$name} = data;

        for (var i = 0; i < data.objects.length; i++) {ldelim}
            availableObjects{$name}[availableObjects{$name}.length] = data.objects[i]['{$field.show_field}'];
            {rdelim}

        $( "#filter_{$name}" ).autocomplete({ldelim}
            source: availableObjects{$name},
            select: function( event, ui )
            {ldelim}
                for (var i=0; i < availableObjectsData{$name}.objects.length; i++)
                {ldelim}
                    if (ui.item.value == availableObjectsData{$name}.objects[i]['{$field.show_field}']) {ldelim}
                        $('#{$name}').val(availableObjectsData{$name}.objects[i]['{$field.identity}']);
                    {rdelim}
                {rdelim}
            {rdelim}
        {rdelim});

        $( "#filter_{$name}" ).autocomplete( "search",  $( "#filter_{$name}").val());
    {rdelim}

    function call{$name}() {ldelim}
        var data = availableObjectsData{$name};
        for (var i = 0; i < data.objects.length; i++)
        {ldelim}
            if (data.objects[i]['{$field.show_field}'] == $( "#filter_{$name}").val())
            {ldelim}
                $( "#{$name}").val((data.objects[i]['{$field.identity}']));
            {rdelim}
        {rdelim}
    {rdelim}

    callFunctions[callFunctions.length] = call{$name};
</script>