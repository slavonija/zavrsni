<?php

namespace App\Interfaces;

interface Sortable{
    public function sortBy(string $field): mixed;
}