<nav class="navbar navbar-inverse">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app_nav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><?php echo lang('HOME') ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="app_nav">
            <ul class="nav navbar-nav">
                <li><a href="categoryies.php"><?php echo lang('CATEGORIES') ?></a></li>
                <li><a href="#"><?php echo lang('ITEMS') ?></a></li>
                <li><a href="members.php"><?php echo lang('MEMBERS') ?></a></li>
                <li><a href="#"><?php echo lang('STATISTICS') ?></a></li>
                <li><a href="#"><?php echo lang('LOGS'); ?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ahmed<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="members.php?do=Edit&id=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>