<input type="text" name="{$f_name}" id="{$f_name}" onkeyup="fill{$f_name}()" value="{$post[$f_name]}" autocomplete="off"/>
<input type="hidden" name="filter_{$f_name}" id="filter_{$f_name}" value="{if $post[$f_name] neq ''}{$filters[$f_name]}{/if}" />

<script>
    var availableObjects{$f_name} = [];
    var availableObjectsData{$f_name} = [];

    function fill{$f_name}() {ldelim}
        var search = $( "#{$f_name}").val();
        if (search != '') {ldelim}
            $.ajax({ldelim}
                dataType: "json",
                url: '/admin/api/{$field.source}/?{$field.show_field}=' + search,
                success: parseJson{$f_name}
            {rdelim});
        {rdelim} else {ldelim}
            $( "#filter_{$f_name}").val('');
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
        {rdelim});

        $( "#{$f_name}" ).autocomplete( "search",  $( "#{$f_name}").val());
    {rdelim}

    function call{$f_name}() {ldelim}
        var data = availableObjectsData{$f_name};
        if (typeof data.objects === "undefined" )
            return;
        for (var i = 0; i < data.objects.length; i++) {ldelim}
            if (data.objects[i]['{$field.show_field}'] == $( "#{$f_name}").val()) {ldelim}
                $( "#filter_{$f_name}").val((data.objects[i]['{$field.identity}']));
            {rdelim}
        {rdelim}
    }

    callFunctions[callFunctions.length] = 'call{$f_name}';
</script>
