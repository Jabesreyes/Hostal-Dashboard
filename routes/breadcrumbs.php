<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Inicio', route('home'), ['icon' => 'fas fa-home']);
});
Breadcrumbs::for('habitacion', function ($trail) {
    $trail->parent('home');
    $trail->push('Habitacion', route('habitacion'),['icon' => 'home']);
});
Breadcrumbs::for('pais', function ($trail) {
    $trail->push('Pais', route('pais'),['icon' => 'home']);
});
