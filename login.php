<?php

session_start();

include('server/connection.php');  // Connecting to the database

if(isset($_SESSION['logged_in']))
{
  header('location:account.php');
  exit;
}

if(isset($_POST['login_btn']))
{

  $email=$_POST['email'];
  $password=$_POST['password'];


  $stmt=$conn->prepare("SELECT user_id,user_name,user_email,user_password FROM users WHERE user_email=? AND user_password=? LIMIT 1");

  $stmt->bind_param('ss',$email,$password);

 if($stmt->execute()){

  $stmt->bind_result($user_id,$user_name, $user_email, $user_password);
  $stmt->store_result();

  if($stmt->num_rows()==1){
    $stmt->fetch();


    $_SESSION['user_id']= $user_id;   // Storing user session
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_email']=$user_email;
    $_SESSION['logged_in'] = true;      //

    header('location:account.php?login_message=You are now logged in successfully!');
  }else{
    header('location:login.php?error=cold not verify your account!');
  }

 }else{

  //error
  header('location: login.php?error=something went wrong!!!');

 }

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

      <!--login-->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" action="login.php" method="POST" >
              <p style="color:red"  class="text-cnter" ><?php if(isset($_GET['error'])){ echo $_GET['error'] ;} ?></p>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required/>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required/>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
                </div>

                <div class="form-group">
                   <a id="register-url" href="register.php" class="btn">Don't have account? Register</a>
                </div>
            </form>
        </div>
      </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>