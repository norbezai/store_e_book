<style type="text/css">
  .notification-num {
    position: absolute;
    top: 1%;
    left: 50%;
    font-size: 20px;
    border-radius: 50%;
    width: 23px;
    height: 23px;
    background-color: red;
    border: 4px solid red;
    text-align: center;
  }

  @media(max-width: 768px){
    .notification-num {
      left: 7%
    }
  }
</style>

<nav class="navbar navbar-inverse" id="navbar" style="border-bottom: 2px solid black;margin-bottom:0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="index.php" style="padding:10px;"><i id="website-name" style="margin-top: 0px;">
          <img src="includes/images/pingo5.png" style="top: 0px; height: 25px;"></i>
        </a>
      </div>

      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav navbar-right">
          <?php
            if(isset($_SESSION['username'])){
              $role = $_SESSION['user_role'];
          ?>
            <li><a href="index.php"><i class="glyphicon glyphicon-home" title="Home" style="font-size: 20px; color: white">
              </i></a>
            </li>
            <li><a href="addBook.php" style="color: white"><span class="glyphicon glyphicon-book"></span> Sell Book</a></li>
            <li>
              <a href="purchase_history.php" style="color: white"><i class="fa fa-history"></i> Purchase history</a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Dashboard"><i class="fa fa-user" style="color: white"></i><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                       <a>WELCOME <?php echo $_SESSION['username'] ?></a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="view_details.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                    </li>
                </ul>
            </li>
          <?php
            }else{
              //SHOW LOGIN AND SIGN UP IN NAVBAR
          ?>
              <li><a href="index.php"><i class="glyphicon glyphicon-home" style="font-size: 20px; color: white"></i></a></li>
              <li><a href="register.php" style="color: white"><span class="glyphicon glyphicon-user" style="color: white">
                </span> Sign Up</a></li>
              <li><a data-toggle="modal" href="" data-target="#loginModal" style="color: white">
                <span class="glyphicon glyphicon-log-in" style="color: white"></span> Login</a></li>
              <?php include "login_modal.php" ?>
          <?php
            if(isset($_SESSION['autostart_modal'])){
                echo "<script>$(window).on('load', function(){
                    $('#loginModal').modal('show');
                  });</script>";
                  $_SESSION['autostart_modal'] = null;
              }
            }
          ?>

        </ul>
      </div>
    </div>
</nav>

<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
