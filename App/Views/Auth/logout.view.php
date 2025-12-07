<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5">
            Boli ste odhlásený. <br>
            Znova sa <a href="<?= App\Configuration::LOGIN_URL ?>">prihlásiť</a> alebo vrátiť <a
                    href="<?= $link->url("home.index") ?>">späť</a> na domovskú stránku?
        </div>
    </div>
</div>
