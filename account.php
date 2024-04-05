<?php
session_start();
include('server/connection.php');

if(!isset( $_SESSION['logged_in'] )) {
  header('location: login.php');
  exit;
}

if(isset( $_GET['logout'])) {

  if(isset($_SESSION['logged_in']))
  {
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    header('location: login.php');

  }

}
if(isset($_POST['change_password']))
{
    $password=$_POST['password'];
    $confirmPassword=$_POST['confirmPassword'];
    $user_email= $_SESSION['user_email'];

    //if password doesn't matches
    if($password !== $confirmPassword)
    {
      header('location:account.php?error=Passwords do not match');

      //if password is less than 8 characters
    } else if(strlen($password) < 8)
      {
        header('location: account.php? error = Password must be at least 8 characters long');
      }
        //no error
      else{
        $stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
        $stmt->bind_param("ss",$password,$user_email);

        if($stmt->execute())
        {
          header('location: account.php?message=Password has been updated successfully!');
        }else{
          header('location: account.php?error= Could not update password !!!');
        }


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

      <!--Account-->
      <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <p class="text-center" style="color:green"><?php if(isset($_GET['register'])){ echo  $_GET['register'];} ?></p>
            <p class="text-center" style="color:green"><?php if(isset($_GET['login_message'])){ echo  $_GET['login_message'];} ?></p>
                <h3 class="font-weight-bold">Account Info</h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p>Name<span>John</span></p>
                    <p>Email<span>john@gmail.com</span></p>
                    <p><a href="" id="orders-btn">Your orders</a></p>
                    <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <form action="account.php" id="account-form" method="POST" >
                  <p class="text-center" style="color:red"><?php if(isset($_GET['error'])){ echo  $_GET['error'];} ?></p>
                  <p class="text-center" style="color:green"><?php if(isset($_GET['message'])){ echo  $_GET['message'];} ?></p>
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required />
                    </div>

                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Password" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Change Password" name="change_password" class="btn" id="change-pass-btn"/>
                    </div>
                </form>
            </div>
        </div>
      </section>

       <!--Orders-->
       <section class = "orders container my-5 py-3">
        <div class="container mt-2">
          <h2 class="font-weight-bold text-center">Your orders</h2>
          <hr class="mx-auto">
        </div>
        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Date</th>
               
            </tr>
            <tr>
                <td>
                   <div class="product-info">
                    <img src="assets/imgs/Oat.png" alt="">
                  <div><p class="mt-3">Oat</p>
                  </div>
                  </div>
                </td>
               
                <td>
                  <span>2023-12-02</span>
                 </td>
                  
            </tr>
           
           
        </table>

      </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>