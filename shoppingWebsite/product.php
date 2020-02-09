<?php
	function ierg4210_cat_fetchall() {
	global $db;
	$db = new PDO('sqlite:../cart.db');
	$q = $db->prepare("SELECT * FROM categories;");
	if ($q->execute())
		return $q->fetchAll();
}
?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>OMall</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<div class="top1">
  			<div class="top-left">
  				<a href="main.php" class="a1" id="h1"><h1>GMall</h1></a>
 			</div>
  			<div class="top-middle">
   			 	<h1>Welcome to GMall!</h1>
 			</div>
  			<div class="top-right">
      			<a href="#" class="a1">About us</a>
      			<span>|</span>
				<a href="#" target="_blank" class="a1">Login</a>
				<span>|</span>
      			<a href="#" target="_blank" class="a1">Register</a>
  			</div>
		</div>
		
		<div class="header1">
  			<div class="shoppingcart"> 
  				<nav>
  					<img src="img/shoppingCart.jpg" width="50px" />
  					<ul id="ul1">
  						<div class="sc-top">
  							<span id="s1">ShoppingList</span><br />
  							<span>Product&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
  							<span>Price&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
  							<span>Quantity</span>
  						</div>
  						
						<div class="sc-bottom">
							<div class="sc-left">
								<h6><a href="#" class="a1">Gibson hummingbirds</a></h6>
							</div>
							<div class="sc-middle">
								<h6>$49999</h6>
							</div>
							<div class="sc-right">
								<input type="text" class="input-num" id="input-num" value="0" />
								<input type="button" id="input-submit" value="submit" />
							</div>							
						</div>	
						<span id="checkout">
							<input type="button" value="Checkout" />
						</span>
  					</ul>
  				</nav> 
  			</div>
  			<div class="search">
    			<form action="#" method="post" id="sitesearch">
      				<fieldset>
        				<input type="text" value="search" onfocus="this.value=(this.value=='search)? '' : this.value ;" />
        				<input type="image" src="img/searchbutton.jpg" width="18px" />
      				</fieldset>
   				 </form>
  			</div>
  		</div>

		<div class="menu">
  			<div class="menu-left">
  				<h4>Category</h4>
  				<?php
  					$db = new PDO('sqlite:../cart.db');
  					$q = 'SELECT catid, name FROM categories';
  					$result = $db->prepare($q);
  					$result->execute();
  					$Category = $result->fetchAll(PDO::FETCH_ASSOC);
  					for($i=0; $i<count($Category); $i++){
  						
  						echo '<button type="button" class = "btn btn-info"><a href="?catid=' .$Category[$i]['catid']. '">'. $Category[$i]['name']. '</a></button><br />';
  					}
  					
  					
  				?>

    		</div>
    		
    		<div class="menu-right">
    			<div class="menu-top">
    				Current location: 
      				<ul>
					<li> <a href="main.php"> Home Page </a> </li>
                    <?php
                    $catid = $_REQUEST["catid"];
               		$pid = $_REQUEST["pid"];
                    	
                    if($catid != null && $pid == null){
                        echo '<li> > </li>';
                        for ($i = 0; $i < count($Category); $i++){  
                            if($Category[$i]['catid'] == $catid){
                                echo '<li> <a href="?catid=' .$catid. '">' .$Category[$i]["name"]. '</a></li>'; 
                            }                         
                        }
                    }
                    else if($catid != null && $pid != null){ 
                        $q = 'SELECT pid, catid, name, price, description FROM products';
                        $result = $db->prepare($q); 
                        $result->execute();            
                        $Product = $result->fetchAll(PDO::FETCH_ASSOC); 
                        
                        echo '<li> > </li>';
                        for ($i = 0; $i < count($Category); $i++){  
                            if($Category[$i]['catid'] == $catid){
                                echo '<li> <a href="?catid=' .$catid. '">' .$Category[$i]["name"]. '</a></li>'; 
                            }                         
                        }
                        echo '<li> > </li>';
                        for ($i = 0; $i < count($Product); $i++){  
                            if($Product[$i]['pid'] == $pid){
                                echo '<li>' .$Product[$i]["name"]. '</li>';  
                            }                         
                        } 
                    }
                    ?>
					</ul>
      				
      				
    			</div>
    			<div class="menu-down">
    				<ul class="table">
 							<?php         
            if ($catid == null){// && $pid == null){
                $q = 'SELECT pid, catid, name, price, description FROM products';
                $result = $db->prepare($q); 
                $result->execute();            
                $Product = $result->fetchAll(PDO::FETCH_ASSOC); 
                
                for ($i = 0; $i < count($Product); $i++){
                	echo '<li>
                			<div class="picture">';
         			echo '<a href="product.php?catid=' .$Product[$i]['catid']. '&pid=' .$Product[$i]['pid']. '">';
         			echo '<img class = productImag src = "img/'.$Product[$i]['pid'].'.jpg" width="100px" />';
         			echo '<h5 class = productDisc >' .$Product[$i]['name'].  '</h5>';
         			echo '<h5 class = productPrice> $' .$Product[$i]['price']. '</h5>';
         			echo '</a><button type "button" onclick="addToCart(\''.$Product[$i]['pid'].'\')" class= "btn btn-danger btn-sm"> Add to Chart </button>';       
                	echo '</div></li>';
                }
                
				
			}
            else if($catid != null && $pid == null){
                $q = 'SELECT pid, catid, name, price, description FROM products Where catid = ?';
                $result = $db->prepare($q); 
                $result->execute(array($catid));            
                $Product = $result->fetchAll(PDO::FETCH_ASSOC); 
                
                for ($i = 0; $i < count($Product); $i++){
                	echo '<li>
                			<div class="picture">';
         			echo '<a href="product.php?catid=' .$Product[$i]['catid']. '&pid=' .$Product[$i]['pid']. '">';
         			echo '<img class = productImag src = "img/'.$Product[$i]['pid'].'.jpg" width="100px" />';
         			echo '<h5 class = productDisc >' .$Product[$i]['name'].  '</h5>';
         			echo '<h5 class = productPrice> $' .$Product[$i]['price']. '</h5>';
         			echo '</a><button type "button" onclick="addToCart(\''.$Product[$i]['pid'].'\')" class= "btn btn-danger btn-sm"> Add to Chart </button>';       
                	echo '</div></li>';
                }            

            }
            else if($catid != null && $pid != null){
                $q = 'SELECT pid, catid, name, price, description FROM products Where pid = ?';
                $result = $db->prepare($q); 
                $result->execute(array($pid));            
                $Product = $result->fetchAll(PDO::FETCH_ASSOC);    
                	echo '<div class="detail">
                			<div class="detail-left">';
         			echo '<img class = productImag src = "img/'.$Product[0]['pid'].'.jpg" width="300px" />
         					</div>';
         			echo '<div class="detail-right">';
         			echo '<h4 class = productDisc >Product Name: ' .$Product[0]['name'].  '</h4>';
         			echo '<h4 class = productPrice>Product Price: $' .$Product[0]['price']. '</h4>';
         			echo '<h4>Description: ' .$Product[0]['description']. '</h4>';
         			echo '<button type "button" onclick="addToCart(\''.$Product[0]['pid'].'\')" class= "btn btn-danger btn-sm"> Add to Chart </button>';       
                	echo '</div>
                			</div>';       
            }
            ?>    
    					
    				</ul>
    			
    			</div>
			</div>
			
    	</div>
	</body>
</html>

