<?php

if (! function_exists('getSelectedCompany')) {
    function getSelectedCompany()
    {
        $user = auth()->user();

        if (!$user) {
            return null;
        }

        $company = $user->company;

        return $company;
    }
}
