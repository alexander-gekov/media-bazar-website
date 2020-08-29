<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-lg">
    <a class="navbar-brand" href="<?php echo URLROOT; ?>/">
        <img src="<?php echo URLROOT; ?>/public/img/Media-Bazar-logo1.jpg" width="50px;" alt="">
    </a>
    <h4 class="mt-2 ml-3 text-md text-purple-dark text-center "><a class="a" href="<?php echo URLROOT; ?>/">Media
            Bazar</a></h4>
    <?php if (isLoggedIn()) : ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/shifts">Shifts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/requests">Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/profiles">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/chat">Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</nav>
