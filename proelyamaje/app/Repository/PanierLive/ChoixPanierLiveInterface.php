<?php

namespace App\Repository\PanierLive;

interface ChoixPanierLiveInterface
{
    public function getLikeToken($token, $field = '*');

    public function updatebyTokens($tokens);

    public function getidlive($code_live);

}

