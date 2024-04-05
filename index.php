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

      <!--Home-->
      <section id="Home">
         <div class="container">
          <!--<h5>NEW ARRIVALS</h5>
          <h1>Best prices for you!</h1>
          <p>Agrihub offers the best products for the most affordable prices</p>
          <button>Shop Now</button>-->
         </div>
      </section>

      <!--Featured Products-->
      <section id="featured" class="my-5 pb-5">
        <div  class="container text-center mt-5 py-5 ">
          <h2>Our Products</h2>
          <hr>
        </div>

        <div class="row mx-auto container-fluid">
          
        <?php include('server/get_featured_product.php'); ?>
        <?php while($row=$featured_products->fetch_assoc()){ ?>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image'];?>" />
            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
            <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
            <a href="<?php echo"single_product.php?product_id=". $row['product_id'];?>" ><button class="buy-btn" >Buy Now</button></a>
          </div>

          <?php }?>
        </div>
      </section>

      <!--Seeds-->
      <section id="featured" class="my-5">
        <div  class="container text-center mt-5 py-5 ">
          <h2>Seeds</h2>
          <hr>
        </div>

        <div class="row mx-auto container-fluid">

        <?php include('server/get_seeds.php'); ?>

        <?php while($row=$seeds_products->fetch_assoc()) { ?>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img src="assets/imgs/<?php echo $row['product_image'];?>" class="img-fluid mb-3"/>
            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
            <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
            <a href="single_product.php"><button class="buy-btn">Buy Now</button></a> 
          </div>

          <?php } ?>


        </div>
      </section>

      <!--Footer-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>