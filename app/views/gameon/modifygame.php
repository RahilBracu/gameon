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
        <section class="form add-game-form">
            <div class="container request-container">
                <p>add a game</p>
                <form class="info" autocomplete="off" method="POST">
                    <input type="text" name="game_name" class="input" value="<?=$data['game_info'][0]->game_name?>" required>
                    <input type="text" name="name" class="input" value="<?=$data['game_info'][0]->name?>" required>
                    <input type="text" name="thumbnail" class="input" value="<?=$data['game_info'][0]->thumbnail?>" required>
                    <input type="hidden" name="avg_rating" class="input" value="0">
                    <input type="hidden" name="avg_rating_per" class="input" value="0">
                    <input type="hidden" name="avg_score" class="input" value="0">
                    <input type="text" name="cover" class="input" value="<?=$data['game_info'][0]->cover?>" required>
                    <textarea name="about" id="ta" required><?=$data['game_info'][0]->about?></textarea>
                    <input type="text" name="platform" class="input" value="<?=$data['game_info'][0]->platform?>" required>
                    <input type="text" name="genre" class="input" value="<?=$data['game_info'][0]->genre?>" required>
                    <input type="text" name="release_date" class="input" value="<?=$data['game_info'][0]->release_date?>" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" required>
                    
                    <?php if($data['system_req']):?>
                        <input type="text" name="p1_m" class="input" value="<?=$data['system_req'][0]->p1_m?>">
                        <input type="text" name="p2_m" class="input" value="<?=$data['system_req'][0]->p2_m?>">
                        <input type="text" name="g1_m" class="input" value="<?=$data['system_req'][0]->g1_m?>">
                        <input type="text" name="g2_m" class="input" value="<?=$data['system_req'][0]->g2_m?>">
                        <input type="text" name="vr_m" class="input" value="<?=$data['system_req'][0]->vr_m?>">
                        <input type="text" name="v_m" class="input" value="<?=$data['system_req'][0]->v_m?>">
                        <input type="text" name="os_m" class="input" value="<?=$data['system_req'][0]->os_m?>">
                        <input type="text" name="dx_m" class="input" value="<?=$data['system_req'][0]->dx_m?>">
                        <input type="text" name="hdd_m" class="input" value="<?=$data['system_req'][0]->hdd_m?>">
                        <input type="text" name="p1_r" class="input" value="<?=$data['system_req'][0]->p1_r?>">
                        <input type="text" name="p2_r" class="input" value="<?=$data['system_req'][0]->p2_r?>">
                        <input type="text" name="g1_r" class="input" value="<?=$data['system_req'][0]->g1_r?>">
                        <input type="text" name="g2_r" class="input" value="<?=$data['system_req'][0]->g2_r?>">
                        <input type="text" name="vr_r" class="input" value="<?=$data['system_req'][0]->vr_r?>">
                        <input type="text" name="v_r" class="input" value="<?=$data['system_req'][0]->v_r?>">
                        <input type="text" name="os_r" class="input" value="<?=$data['system_req'][0]->os_r?>">
                        <input type="text" name="dx_r" class="input" value="<?=$data['system_req'][0]->dx_r?>">
                        <input type="text" name="hdd_r" class="input" value="<?=$data['system_req'][0]->hdd_r?>">
                    <?php else:?>
                        <input type="text" name="p1_m" class="input" placeholder="Required Intel Processor (Minimum)">
                        <input type="text" name="p2_m" class="input" placeholder="Required AMD Processor (Minimum)">
                        <input type="text" name="g1_m" class="input" placeholder="Required Nvidia Graphics Card (Minimum)">
                        <input type="text" name="g2_m" class="input" placeholder="Required AMD Graphics Card (Minimum)">
                        <input type="text" name="vr_m" class="input" placeholder="Required VRAM (Minimum)">
                        <input type="text" name="v_m" class="input" placeholder="Required RAM (Minimum)">
                        <input type="text" name="os_m" class="input" placeholder="Required Operating System (Minimum)">
                        <input type="text" name="dx_m" class="input" placeholder="Required DirectX (Minimum)">
                        <input type="text" name="hdd_m" class="input" placeholder="Required Disk Space (Minimum)">
                        <input type="text" name="p1_r" class="input" placeholder="Required Intel Processor (Recommended)">
                        <input type="text" name="p2_r" class="input" placeholder="Required AMD Processor (Recommended)">
                        <input type="text" name="g1_r" class="input" placeholder="Required Nvidia Graphics Card (Recommended)">
                        <input type="text" name="g2_r" class="input" placeholder="Required AMD Graphics Card (Recommended)">
                        <input type="text" name="vr_r" class="input" placeholder="Required VRAM (Recommended)">
                        <input type="text" name="v_r" class="input" placeholder="Required RAM (Recommended)">
                        <input type="text" name="os_r" class="input" placeholder="Required Operating System (Recommended)">
                        <input type="text" name="dx_r" class="input" placeholder="Required DirectX (Recommended)">
                        <input type="text" name="hdd_r" class="input" placeholder="Required Disk Space (Recommended)">
                    <?php endif;?>
                        
                        <input type="submit" class="form-btn" value="modify">
                    </form>
            </div>
        </section>
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