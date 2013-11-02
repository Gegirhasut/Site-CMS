<input type="text" name="{$f_name}" id="{$f_name}" onkeyup="fill{$f_name}()" value="{$post[$f_name]}"/>
<input type="hidden" name="filter_{$f_name}" id="filter_{$f_name}" value="{$filters[$f_name]}" />

<script>
    var availableObjects{$f_name} = [];
    var availableObjectsData{$f_name} = [];

    function fill{$f_name}() {ldelim}
        var search = $( "#{$f_name}").val();
        if (search != '') {ldelim}
            $.ajax({ldelim}
                dataType: "json",
                url: '/admin/api/{$field.source}/' + search,
                success: parseJson{$f_name}
            {rdelim});
        {rdelim}
    {rdelim}

    function parseJson{$f_name}(data) {ldelim}
        availableObjects{$f_name} = [];
        availableObjectsData{$f_name} = data;

        for (var i = 0; i < data.objects.length; i++) {ldelim}
            availableObjects{$f_name}[availableObjects{$f_name}.length] = data.objects[i]['{$field.show_field}'];
        {rdelim}

        $( "#{$f_name}" ).autocomplete({ldelim}
            source: availableObjects{$f_name},
            onSelect: function( event, ui ) {ldelim}
                alert(1);
            {rdelim}
        {rdelim});
    {rdelim}

    function call{$f_name}() {ldelim}
        var data = availableObjectsData{$f_name};
        for (var i = 0; i < data.objects.length; i++) {ldelim}
            if (data.objects[i]['{$field.show_field}'] == $( "#{$f_name}").val()) {ldelim}
                $( "#filter_{$f_name}").val((data.objects[i]['{$field.identity}']));
            {rdelim}
        {rdelim}
    }

    callFunctions[callFunctions.length] = call{$f_name};
</script>
