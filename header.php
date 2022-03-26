<div class="header">
    <div class="container">
        <div class="image-logo">
            <a href="<?php echo Link::getLink('index')?>">
                <img src="assets/logo.png" alt="" class="img-logo">
            </a>
        </div>
        <?php
            $user = new User($_SESSION['id_user']);
            $current_location = Link::get_current_location();
            if ($user->getAccessLevel() == 2) {
                $current_location == 'logs' ? $class = 'item-selected' : $class = '';
                echo '<div class="management">
                    <div class="management_inner">
                        <div class="management_main">
                            <span>
                                Management  
                            </span>
                        </div>
                        <div class="management_actions">
                            <div class="management_action '.$class.'">
                                <a href="'.Link::getLink('logs').'">
                                    Loguri
                                </a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        ?>
        <div class="my-account">
            <div class="my-account-inner">
                <span class="material-icons">
                    person
                </span>
                <span>
                    My account
                </span>
            </div>
            <div class="my-account-preview">
                <div class="my-account-preview-name">
                    <span>
                        Salut,
                        <?php
                        $user = User::getDetails($_SESSION['id_user']);
                        echo $user['first_name'].' '.$user['last_name'];
                        ?>
                    </span>
                </div>
                <a href="<?php
                if ($current_location == 'my_account') {
                    echo '#';
                } else {
                    echo Link::getLink('my_account');
                }
                ?>">
                    <div class="my-account-preview-href <?php if ($current_location == 'my_account') echo 'item-selected'?>">
                        <span>
                            Contul meu
                        </span>
                    </div>
                </a>
                <a href="<?php echo Link::getLink('log-out', 'events')?>">
                    <div class="my-account-preview-log-out">
                        <span>
                            Log out
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
