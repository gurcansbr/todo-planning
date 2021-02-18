<?php

namespace App\Contracts;

interface ApiProvider {
    public function getDataFromApi();

    public function storeData($tasks);
}