<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ASSETS?>gameon/style.css">
    <script src="https://kit.fontawesome.com/0d43232e81.js" crossorigin="anonymous"></script>
    <title><?=$data['page_title']." | ".WEBSITE_TITLE?></title>
</head>
<body>
    <header>
        <img class="logo" src="<?=ASSETS?>gameon/img/logo.svg" alt="logo">
        <nav>
            <ul class="nav_links">
            <li><a href="<?=ROOT?>home">Home</a></li>
                <li><a href="<?=ROOT?>search">Games</a></li>
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 0):?>
                    <li><a class="admin-a" href="<?=ROOT?>addgame">Add Games</a></li>
                <?php elseif(isset($_SESSION['user_id'])):?>
                    <li><a href="<?=ROOT?>account/<?=$_SESSION['username']?>/account-info">Account</a></li>
                <?php else:?>
                    <li><a href="<?=ROOT?>account">Account</a></li>
                <?php endif;?>
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 0):?>
                    <li><a class="admin-a" href="<?=ROOT?>criticrequest">Pending Reviews</a></li>
                <?php elseif(isset($_SESSION['user_id'])):?>
                    <li class="hi"><p>@<?=$_SESSION['username']?></p></li>
                <?php endif;?>
            </ul>
        </nav>
        <?php if(!isset($_SESSION['username'])):?>
            <a href="<?=ROOT?>signin">
            <div class="login">
                sign in <i class="fas fa-sign-in-alt"></i>
            </div>
            </a>
        <?php else:?>
            <a href="<?=ROOT?>signout">
            <div class="login">
                sign out <i class="fas fa-sign-out-alt"></i>
            </div>
            </a>
        <?php endif;?>
    </header>
    <main>
        <form class="form" autocomplete="off" method="POST">
            <div class="sign-in-bg bg-pos"></div>
            <div class="container">
                <p>sign in</p>
                <div class="info">
                    <input type="text" name="username" class="input" placeholder="Username" required>
                    <input type="password" name="password" class="input" placeholder="Password" required>
                    <input type="submit" class="form-btn" value="sign in">
                    <p>Don't have an account? <a href="<?=ROOT?>register">Create a new account</a></p>
                </div>
                <div class="error-container"><p><?php check_message()?></p></div>
            </div>
        </form>
    </main>
    <footer>
        <div class="footer">
            <div class="gameon">
                <img class="logo" src="<?=ASSETS?>gameon/img/logo-footer.svg" alt="logo">
                <p>Failure doesn't mean the game is over, it means try again with experience.</p>
                <div class="social">
                    <div class="social-icons"><i class="fab fa-discord"></i></div>
                    <div class="social-icons"><i class="fab fa-facebook-f"></i></div>
                    <div class="social-icons"><i class="fab fa-instagram"></i></div>
                    <div class="social-icons"><i class="fab fa-twitter"></i></div>
                </div>
            </div>
            <div class="criterias footer-criterias">
                <h3>search games</h3>
                <form class method="POST" action="<?=ROOT?>search">
                    <input class="input" type="hidden" name="criteria" value="SELECT * FROM games WHERE platform LIKE '%PC%'">
                    <button type="submit">
                        <p>Available on PC</p>
                    </button>
                </form>
                <form class method="POST" action="<?=ROOT?>search">
                    <input class="input" type="hidden" name="criteria" value="SELECT * FROM games WHERE platform LIKE '%Xbox One%'">
                    <button type="submit">
                        <p>Available on Xbox One</p>
                    </button>
                </form>
                <form class method="POST" action="<?=ROOT?>search">
                    <input class="input" type="hidden" name="criteria" value="SELECT * FROM games WHERE platform LIKE '%PlayStation 4%'">
                    <button type="submit">
                        <p>Available on PlayStation 4</p>
                    </button>
                </form>
            </div>
            <div class="office">
                <h3>our office</h3>
                <p>458 West Green Hill St. Holly Springs, NC 27540</p>
            </div>
            <div class="contact">
                <h3>e-mail</h3>
                <p>rahil.bin.mushfiq@g.bracu.ac.bd</p>
                <h3 class="phone">phone</h3>
                <p>+1 319-566-5362</p>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright © <span>Game On</span> - 2021. All Rights Reserved</p>
        </div>
    </footer>
</body>
</html>