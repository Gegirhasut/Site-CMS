<script type="text/javascript" src="/js/jquery.notice.js"></script>

<script language="javascript">
{literal}

	function updateProduct(id, count)
	{
	    if (typeof(count) === 'undefined') {
	        count = parseInt(jQuery('#c_' + id).val());
	    }
	
	    jQuery.getJSON(
	        "/cart/?operation=update&id=" + id + "&count=" + count,
	        function (data) {
	            Basket.add("Ваша корзина обновлена");
	            updateCart(data.count, data.price);
	            if (data.del == 1) {
	                jQuery('#tr_' + id).remove();
	            } else {
	                jQuery('#p_' + id).html(data.new_price);
	            }
	            
	            jQuery('#total_price').html(data.price);
	            
	            updateCart(data.count, data.price);
	        }
	    );
	}
	
	function addProduct(id, count)
	{
	    if (typeof(count) === 'undefined') {
	        count = parseInt(jQuery('#c_' + id).val());
	    }
	
	    jQuery.getJSON(
	        "/cart/?operation=add&id=" + id + "&count=" + parseInt(count),
	        function (data) {
	            Basket.add("Товар добавлен в корзину");
	            updateCart(data.count, data.price);
	        }
	    );
	}
	 
	 var Basket = {
	        add: function(message) {
	            jQuery.noticeAdd({
	                text: message,
	                stay: false
	            });
	        }
	};
	
	
	 function updateCart(count, price)
	 {
	    if (count == 0) {
	    	jQuery('#cart').html('Ваша корзина пуста.');
	    	jQuery('#issue_order').hide();
	    } else {
		    var ost = count %10;
		    var tovar = "товаров";
		    switch (ost) {
		        case 1: tovar = "товар"; break;
		        case 2:
		        case 3:
		        case 4: tovar = "товара"; break;
		    }
		    if (count >= 5 && count <= 20) {
		        tovar = "товаров";
		    }
		    jQuery('#cart').html('В корзине <a href="/cart/">' + count + ' ' + tovar + '</a><br/> на сумму <b>' + price + '</b> руб.');
		    jQuery('#issue_order').show();
		}
	 }
{/literal}

{if !isset($clean_cart)}
	{literal}	 
		 jQuery.getJSON(
		        "/cart/?operation=get",
		        function (data) {
		            updateCart(data.count, data.price);
		        }
		 );
	{/literal}
{/if}

</script>
