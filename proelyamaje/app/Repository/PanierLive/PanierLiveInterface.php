<?php

namespace App\Repository\PanierLive;

interface PanierLiveInterface
{
    public function getByIds($ids, $field = '*');

    public function getPanierByTokens($tokens);

    public function getAllPanier();
}

