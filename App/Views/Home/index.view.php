<?php
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container home-page my-5">

    <!-- Hero / welcome banner -->
    <div class="row mb-5">
        <div class="col text-center">
            <h1 class="display-4">Vitajte v BookShelf</h1>
            <p class="lead">
                Objavujte, čítajte a spravujte svoje obľúbené knihy na jednom mieste.
            </p>
        </div>
    </div>

    <!-- Featured categories or recommendations -->
    <div class="row mb-5 text-center">
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100 p-3">
                <img src="<?= $link->asset('images/genres.png') ?>" alt="Žánre" class="feature-img mb-3">
                <h5>Žánre</h5>
                <p>Prehľadajte knihy podľa žánrov a nájdite nové obľúbené tituly.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100 p-3">
                <img src="<?= $link->asset('images/authors.png') ?>" alt="Autori" class="feature-img mb-3">
                <h5>Autori</h5>
                <p>Objavte knihy od vašich obľúbených autorov a spoznajte nových spisovateľov.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100 p-3">
                <img src="<?= $link->asset('images/recommend.png') ?>" alt="Odporúčané" class="feature-img mb-3">
                <h5>Odporúčané</h5>
                <p>Inšpirujte sa odporúčaniami a objavte bestsellery a skryté perly.</p>
            </div>
        </div>
    </div>

    <!-- About section -->
    <div class="row mb-5">
        <div class="col text-center">
            <h2>O BookShelf</h2>
            <p class="mt-3">
                BookShelf je moderná knižnica, ktorá vám umožní prehľadne spravovať vašu zbierku kníh,
                vyhľadávať nové tituly a objavovať obľúbené žánre a autorov. Vytvorená pre čitateľov a nadšencov kníh.
            </p>
        </div>
    </div>

</div>
