window.onload = function(){	
	window.data = [];
	refreshCart();
}

function refreshCart() {
    var tmpCart;
    if(localStorage.cart != undefined){
        tmpCart = JSON.parse(localStorage.cart);
    }
    var content = "<table> <tr> <th> Product </th> <th> Price </th> <th> Count </th> <th> Total </th> </tr>";
    var total = 0;
    var totalForOneProd = 0;
    for (var p in tmpCart){
        totalForOneProd = tmpCart[p].num * tmpCart[p].price;
        content += "<tr><td>" + tmpCart[p].name + "</td> <td>$" + tmpCart[p].price + "</td>" +         
            "<td><input type=\"text\"  value=" + tmpCart[p].num + " oninput=\"updatePrice(" + p + ",this.value)\" /></td>" +
            "<td>$"+totalForOneProd+"</td>";
        total += totalForOneProd;
    }
    content += "</table>";
    content += "Total: $"+total;
    
    var form = "<form id=\"payForm\" action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"POST\" onsubmit=\"return cart_submit(this)\">";
    form += "<input type=\"hidden\" name=\"cmd\" value=\"_cart\">";
    form += "<input type=\"hidden\" name=\"upload\" value=\"1\">";
    form += "<input type=\"hidden\" name=\"business\" value=\"hude1328@gamil.com\">";
    form += "<input type=\"hidden\" name=\"currency_code\" value=\"HKD\">";
    form += "<input type=\"hidden\" name=\"charset\"  value=\"utf-8\">";

    var list_num = 1;
    for (var p1 in tmpCart){
        form += "<input type=\"hidden\" name=\"item_name_"+ list_num +"\" value=\""+ tmpCart[p1].name +"\"  >" ; //product name
        form += "<input type=\"hidden\" name=\"item_number_"+ list_num +"\" value=\""+ p1 + "\" >"; //product reference number
        form += "<input type=\"hidden\" name=\"quantity_"+ list_num +"\" value=\""+ tmpCart[p1].num +"\" >"; //product count
        form += "<input type=\"hidden\" name=\"amount_"+ list_num +"\" value=\""+ tmpCart[p1].price +"\"  >" ; //product price
        list_num += 1;
    }
    form += "<input type=\"hidden\" name=\"custom\" value=\"\">";
    form += "<input type=\"hidden\" name=\"invoice\" value=\"\">";
    form += "<input type=\"submit\" id=\"checkout\" value=\"Checkout\"></form> ";
    content += form;
    
    document.getElementById("shoppingcart").innerHTML = content;
}



function addToCart(pid){
	var xhr = new XMLHttpRequest();
	var url = "cart-process.php?action=prod_fetchbypid&pid=";
	url = url + pid;
	xhr.open("GET", url, true);
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			window.data = JSON.parse(xhr.responseText);
				console.log(window.data);
   				var cart = localStorage.cart;
    			if (cart == undefined)
        			cart = {};
    			else
        			cart = JSON.parse(cart);
    			if(cart[pid] == undefined)
      				cart[pid] = {num:0};
    			cart[pid].name = window.data[0];
    			cart[pid].price = window.data[1];
   				cart[pid].num = cart[pid].num + 1;
    			localStorage.cart = JSON.stringify(cart);
    			refreshCart();
		}
	};	
	xhr.send(null);	
	
	/*
	console.log(window.data);
    var cart = localStorage.cart;
    if (cart == undefined)
        cart = {};
    else
        cart = JSON.parse(cart);
    if(cart[pid] == undefined)
        cart[pid] = {num:0};
    	cart[pid].name = window.data[0];
    	cart[pid].price = window.data[1];
   		cart[pid].num = cart[pid].num + 1;
    localStorage.cart = JSON.stringify(cart);
    refreshCart();
     异步造成window.data数据获取滞后
    */
}

/*
function sendAjax(pid){
	var xhr = new XMLHttpRequest();
	var url = "cart-process.php?action=prod_fetchbypid&pid=";
	url = url + pid;
	xhr.open("GET", url, true);
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			window.data = JSON.parse(xhr.responseText);	
			console.log(data);
		}
	};	
	xhr.send(null);
	
	return window.data;
}
*/

function updatePrice(p, number) {
    var tmpCart = JSON.parse(localStorage.cart);
    if(number > 0){
        tmpCart[p].num = number;
        localStorage.cart = JSON.stringify(tmpCart);
    }
    else if(number == 0) {
        delete tmpCart[p];
        localStorage.cart = JSON.stringify(tmpCart);
    }
    refreshCart();
}


