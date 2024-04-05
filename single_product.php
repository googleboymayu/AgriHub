<?php

include('server/connection.php');
if(isset($_GET['product_id']))
{
  $product_id=$_GET["product_id"];

  $stmt=$conn->prepare("SELECT * FROM products where product_id=?");
  $stmt->bind_param("i",$product_id);
  $stmt->execute();

  $product=$stmt->get_result();

}// no product_id was given
else{
  header( "location: index.php" );
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

    <style>
         .product img{
            width: 60%;
            height: 60%;
            box-sizing: border-box;
            object-fit: cover;
        }
    </style>
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

      <!--Single product-->
      <section class="container single-product my-5 pt-5">
        <div class="row mt-5">


          <?php while($row=$product->fetch_assoc()){ ?>
            
            
              <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image']; ?>" id="mainImg" />
                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img"/>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-md-12 col-12">
                <h3><?php echo $row['product_name']; ?></h3>
                <h4 class="py-4"><?php echo $row['product_category']; ?></h4>
                <h4>Rs<?php echo $row['product_price']; ?></h4>

                <form action="cart.php" method="POST">
                  <input type="hidden" name="product_id" value="<?php echo $row['product_id']?>"/>
                  <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
                  <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
                  <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

                  <input type="number" name="product_quantity" value="1"/>
                  <button class="buy-btn" type="submit" name="add_to_cart" >Add To Cart</button>
                </form>

                <h5 class="mt-5 mb-5">Product Detail:</h5>
                <h5><span><?php echo $row['product_description']; ?></span></h5>
               
            </div>
            
            <?php }?>

        </div>
      </section>


       <!--Related Products-->
       <section id="related-products" class="my-5 pb-5">
        <div  class="container mt-5 py-5 ">
          <h2>Related Products</h2>
          <hr>
          
        </div>
        <div class="row mx-auto container-fluid">
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img src="assets/imgs/Hunker.jpg" class="img-fluid mb-3"/>
            <h5 class="p-name">Hunker</h5>
            <h4 class="p-price">Rs 300</h4>
            <button class="buy-btn">Buy Now</button>
          </div>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img src="assets/imgs/Water pump.jpg" class="img-fluid mb-3"/>
            <h5 class="p-name">Water pump</h5>
            <h4 class="p-price">Rs 3000</h4>
            <button class="buy-btn">Buy Now</button>
          </div>


          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img src="assets/imgs/Sunflower seeds.jpg" class="img-fluid mb-3"/>
            <h5 class="p-name">Sunflower seeds</h5>
            <h4 class="p-price">Rs 499</h4>
            <button class="buy-btn">Buy Now</button>
          </div>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img src="assets/imgs/SweetCorn.png" class="img-fluid mb-3"/>
            <h5 class="p-name">Sweet Corn</h5>
            <h4 class="p-price">Rs 299</h4>
            <button class="buy-btn">Buy Now</button>
          </div>
        </div>
      </section>

      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      var mainImg = document.getElementById("mainImg");
      var smallImg= document.getElementsByClassName("small-img");
      for (let i=0; i<4;i++)
      {
        smallImg[i].onclick=function(){
        mainImg.src=smallImg[i].src;

      }
      }
     
    </script>
  </body>
</html>