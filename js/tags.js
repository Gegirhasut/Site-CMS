Array.prototype.add = function()
{
	for (i = 0; i < this.length; i++)
	{
		if (this[i] > arguments[0]) break;
	}
	for (y = this.length - 1; y >= i; y--)
	{
		this[y+1] = this[y];
	}
	this[i] = arguments[0];
	return this;
}

Array.prototype.remove = function()
{
    var what, a = arguments, L = a.length, ax;
    while(L && this.length)
    {
        what = a[--L];
        while((ax = this.indexOf(what))!= -1){
            this.splice(ax, 1);
        }
    }
    return this;
}

function addObject(o_id, link_object, join_object, object_name)
{
	var object = ($("#object" ).val());
	if (object == "") return;
	
	$.post(
		"/ajax/many_to_many/",
		{id: o_id, tag: object, operation: "add_object", link_object: link_object, join_object: join_object, object_name: object_name},
		function (id) {
			if (id != 0) {
				addObjectElement(id, object, link_object);
				availableTags.remove(object);
				$('#tag').autocomplete({source: availableTags});
			}
		}
	);
	
	$("#object" ).val('');
}

function addObjectElement(id, object, link_object)
{
	$("#users_objects").append(
			'<div id="object_' + id + '"></span>' + object + 
			'&nbsp;&nbsp;</span><img width="16px;" src="/images/icons/minus.png" onClick="delObject(' + id + ', \'' + object + 
			'\' ' + ', \'' + link_object + '\')" ></div>'
	);
}

function delObject(id, object, link_object)
{
	$.post(
		"/ajax/many_to_many/",
		{id: id, operation: "del_object", link_object: link_object},
		function (id_data) {
			$('#object_' + id_data).remove();
			availableObjects.add(object);
			$("#object").autocomplete({source: availableTags});
		}
	);
}