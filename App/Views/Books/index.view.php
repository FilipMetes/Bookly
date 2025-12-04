<?php

use App\Configuration;
use App\Models\User;

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('root');
?>

<?php $user = $this->app->getSession()->get(Configuration::IDENTITY_SESSION_KEY);;
if ($user && $user->role === 'A'): ?>
<div class="container books-catalog my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="catalog-title">Katalóg kníh</h2>
        <div class="search-wrap">
            <label for="bookSearch" class="visually-hidden">Vyhľadať</label>
            <input id="bookSearch" class="form-control" type="search" placeholder="Vyhľadať knihu alebo autora...">
        </div>
    </div>

    <div class="row g-3 books-grid">
        <!-- Example book card 1 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card h-100">
                <div class="book-cover" style="background-image: url('<?= $link->asset('images/vaiicko_logo.png') ?>')"></div>
                <div class="card-body d-flex flex-column">
                    <h5 class="book-title">Názov knihy 1</h5>
                    <p class="book-author mb-1">Autor: Ján Novák</p>
                    <p class="book-genre text-muted mb-2">Žáner: Dobrodružstvo</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <strong class="book-price">€12.90</strong>
                        <a class="btn btn-outline-primary btn-sm" href="#">Detail</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Example book card 2 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card h-100">
                <div class="book-cover" style="background-image: url('<?= $link->asset('images/vaiicko_logo.png') ?>')"></div>
                <div class="card-body d-flex flex-column">
                    <h5 class="book-title">Názov knihy 2</h5>
                    <p class="book-author mb-1">Autor: Mária Kováčová</p>
                    <p class="book-genre text-muted mb-2">Žáner: Román</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <strong class="book-price">€9.50</strong>
                        <a class="btn btn-outline-primary btn-sm" href="#">Detail</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Example book card 3 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card h-100">
                <div class="book-cover" style="background-image: url('<?= $link->asset('images/vaiicko_logo.png') ?>')"></div>
                <div class="card-body d-flex flex-column">
                    <h5 class="book-title">Názov knihy 3</h5>
                    <p class="book-author mb-1">Autor: Peter Horváth</p>
                    <p class="book-genre text-muted mb-2">Žáner: Sci-Fi</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <strong class="book-price">€15.00</strong>
                        <a class="btn btn-outline-primary btn-sm" href="#">Detail</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Example book card 4 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card h-100">
                <div class="book-cover" style="background-image: url('<?= $link->asset('images/vaiicko_logo.png') ?>')"></div>
                <div class="card-body d-flex flex-column">
                    <h5 class="book-title">Názov knihy 4</h5>
                    <p class="book-author mb-1">Autor: Lucia Bieliková</p>
                    <p class="book-genre text-muted mb-2">Žáner: Detektívka</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <strong class="book-price">€7.20</strong>
                        <a class="btn btn-outline-primary btn-sm" href="#">Detail</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add more cards as needed -->
    </div>
    <?php endif; ?>
</div>
