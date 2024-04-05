<?php
include('server/connection.php');
session_start();

if(isset($_POST['add_to_cart'])) 
{ 
  //if user has already added a product to cart
  if(isset( $_SESSION['cart']))
  {   
     $products_array_ids=array_column( $_SESSION['cart'],"product_id");//[2,3,4,10,15]
     //if product already ha been  added to cart or not
     if(!in_array($_POST['product_id'],$products_array_ids)){

      $product_id=$_POST['product_id'];
    
        $product_array=array(
        'product_id'=>$_POST['product_id'],
        'product_name'=>$_POST['product_name'],
        'product_price'=>$_POST['product_price'],
        'product_image'=>$_POST['product_image'],
        'product_quantity'=>$_POST['product_quantity']
      );
      $_SESSION['cart'][$product_id]=$product_array;
     } 
     //product has alredy added
     else{
         echo'<script>alert("Product was already add to cart")</script>';
         //echo'<script>window.location="index.php"</script>';
     } 
  }
  //if this is the first product 
  else{
    $product_id=$_POST['product_id'];
    $product_name=$_POST['product_name'];
    $product_price=$_POST['product_price'];
    $product_image=$_POST['product_image'];
    $product_quantity=$_POST['product_quantity'];

    $product_array=array(
      'product_id'=>$product_id,
      'product_name'=>$product_name,
      'product_price'=>$product_price,
      'product_image'=>$product_image,
      'product_quantity'=>$product_quantity
    );
    $_SESSION['cart'][$product_id]=$product_array;
  }

    //calculate total
    calculateTotalCart();



  
}
//remove product from cart
else if(isset($_POST['remove_product'])){


  $product_id=$_POST['product_id'];
  unset($_SESSION['cart'][$product_id]);

  //calculate total
calculateTotalCart();
}

else if(isset($_POST['edit_quantity'])){


  //we get the id and quantity from the form
  $product_id=intval($_POST["product_id"]);
  $product_quantity=$_POST['product_quantity'];

  //get the product array from the session
  $product_array=$_SESSION['cart'][$product_id];
  
  //update the product quantity in the array
  $product_array['product_quantity']=$product_quantity;

  //put the product back in the session with the updated info
  //return array back its place
  $_SESSION['cart'][$product_id]=$product_array;

  //calculate total
  calculateTotalCart();

}else
{ 
  echo'<script>alert("Cart is empty")</script>';
  //header("location: index.php");
  
}

function calculateTotalCart(){
    
  $total=0;

    foreach($_SESSION['cart'] as $key => $value){

      $product=$_SESSION['cart'][$key];

      $price = $product['product_price'];
      $quantity = $product['product_quantity'];

      $total = $total+($price*$quantity);
    }

    $_SESSION['total']=$total;

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGRIHUB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"  href="assets/css/style.css"/>
</head>
<body>
   <!--Navbar-->
   <nav class="navbar navbar-expand-lg navbar-light bg-white  fixed-top ">
    <div class="container-fluid">
     <img src="assets/imgs/logo2.png" height="50px" width="150px" />
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="product.html">Product</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">Blog</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact Us</a>
          </li>


          <li class="nav-item">
            <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="account.php"><i class="fas fa-user"></i></a>
          </li>

        </ul>
        
      </div>
    </div>
  </nav>

      <!--cart-->
      <section class = "cart container my-5 py-5">
        <div class="container mt-5">
          <h2 class="font-weight-bolde">Your cart</h2>
          <hr>
        </div>
        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach ($_SESSION['cart'] as $key => $value){ ?>

            <tr>
                <td>
                    <div class="product_info">
                        <img src="assets/imgs/<?php echo  $value['product_image'];?>" alt="">
                        <div>
                           <p><?php echo  $value['product_name']; ?></p>
                           <small><span>Rs</span><?php echo  $value['product_price']; ?></small>
                           <br>
                           <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                           <input type="submit" name="remove_product" class="remove-btn" value="remove" /> 
                           </form>
                           
                        </div>
                    </div>
                </td>
                <td>
                    
                    <form action="cart.php" method="POST" >
                     <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>"/>
                     <input type="number" name="product_quantity" value="<?php echo  $value['product_quantity'];?>"/>
                     <input type="submit" class="edit-btn" value="edit" name="edit_quantity" />
                    </form>
                    
                </td>
                <td>
                    <span>Rs</span>
                    <span ckass="product-price"><?php echo $value['product_quantity'] * $value['product_price']; ?></span>
                </td>
            </tr>
           
            <?php } ?>

        </table>
            <div class="cart-total">
                <table>
                     <tr>
                        <td>Total</td>
                        <td>Rs <?php  echo $_SESSION['total']; ?></td>
                     </tr>
                </table>
               
            </div>

            <div class="checkout-container">
              <form method="POST" action="checkout.php">
                <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout" />
              </form>
            </div>
      </section>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>