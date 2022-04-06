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
                $current_location == 'logs' ? $class_logs = 'item-selected' : $class_logs = '';
                $current_location == 'inventory' ? $class_inventory = 'item-selected' : $class_inventory = '';
                $current_location == 'recipes' ? $class_recipes = 'item-selected' : $class_recipes = '';
                $current_location == 'accounts' ? $class_accounts = 'item-selected' : $class_accounts = '';
                $current_location == 'invoices' ? $class_invoices = 'item-selected' : $class_invoices = '';
                echo '<div class="management">
                    <div class="management_inner">
                        <div class="management_main">
                            <span>
                                Management  
                            </span>
                        </div>
                        <div class="management_actions">
                            <div class="management_action '.$class_logs.'">
                                <a href="'.Link::getLink('logs').'">
                                    Logs
                                </a>
                            </div>
                            <div class="management_action '.$class_accounts.'">
                                <a href="'.Link::getLink('accounts').'">
                                    Accounts
                                </a>
                            </div>
                            <div class="management_action '.$class_inventory.'">
                                <a href="'.Link::getLink('inventory').'">
                                    Inventory
                                </a>
                            </div>
                            <div class="management_action '.$class_recipes.'">
                                <a href="'.Link::getLink('recipes').'">
                                    Recipes
                                </a>
                            </div>
                            <div class="management_action '.$class_invoices.'">
                                <a href="'.Link::getLink('invoices').'">
                                    Invoices
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
            </div>
            <div class="my-account-preview">
                <div class="my-account-preview-name">
                    <span>
                        Hi,
                        <?php
                        $user = User::getDetails($_SESSION['id_user']);
                        echo $user['first_name'].' '.$user['last_name'];
                        ?>
                    </span>
                </div>
                <div <?php if ($current_location == 'my_account') echo 'class="item-selected"'?>>
                    <a href="<?php echo Link::getLink('my_account'); ?>">
                        <div class="my-account-preview-href">
                        <span>
                            My Account
                        </span>
                        </div>
                    </a>
                </div>
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
