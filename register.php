<?php

session_start();


include('server/connection.php'); 

   // if user has already registerd then take user to account page
  if(isset($_SESSION['logged_in']))
  {
    header('location: account.php');
    
    exit;

  }

if(isset($_POST['register']))
{

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword= $_POST['confirmPassword'];

    //if password doesn't matches
    if($password !== $confirmPassword)
    {
      header('location:register.php?error=Passwords do not match');

      //if password is less than 8 characters
    } else if(strlen($password) < 8)
      {
        header('location: register.php? error = Password must be at least 8 characters long');


        //if there is no erreor  
}else
      {

        //check whether there is a user with this email or not
        $stmt1=$conn->prepare("SELECT count(*) FROM users where  user_email = ?");
        $stmt1->bind_param("s",$user_email);
        $stmt1->execute();
        $stmt1->bind_result($num_rows);
        $stmt1->store_result();
        $stmt1->fetch();
        
        // if there a user already registered with this email
        if ($num_rows !=0){
          header('location: registe.php?error=user with this email already exists');
        }
            //if no user registered with the  same email then insert data into database
        else{
              //create   a new user
              $stmt = $conn->prepare("INSERT INTO users(user_name,user_email,user_password)
                      VALUES (?,?,?)");

              $stmt->bind_param('sss',$name,$email,$password);

              // if account was created successfully
              if($stmt->execute())
              {
                $user_id = $stmt->insert_id;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email']=$email;
                $_SESSION['user_name']=$name;
                $_SESSION['logged_in']=true;
                header('location:account.php?register=You registered successfully');
              }
              // account could not be created
              else
              {
                header('location: register.php?error=Could not create account at this moment');
              }
            }
       
      }

}








/*
else{

  //header('location: register.php?error=please fill the form properly');
  
}
*/


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

      <!--Register-->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-3">
            <h2 class="form-weight">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="register-form" method="POST" action="register.php" >
              <p style="color:red" ><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required/>
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
                </div>
                
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required/>
                </div>
                
                <div class="form-group">
                    <label> Confirm Password:</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required/>
                </div>
                
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
                </div>
                <div class="form-group">
                   <a id="login-url" href="login.php" class="btn">Do you have account? Login</a>
                </div>
            </form>
        </div>
      </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>