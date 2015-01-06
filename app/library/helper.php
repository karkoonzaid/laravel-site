<?php

/**
 * Class Helper
 * All Helper functions
 */

class Helper {
    public static  function isMod() {
        if (!(Entrust::hasRole('admin') || (Entrust::hasRole('moderator')))) // Checks the current user
        {
            return false;
        }
        return true;
    }

    public static  function isAdmin() {
        if (!(Entrust::hasRole('admin'))) // Checks the current user
        {
            return false;
        }
        return true;
    }

    public static  function isOwner($userId) {
        if (Auth::user()) {
            if (Auth::user()->getAuthIdentifier() === $userId) {
                return true;
            }
            return false;
        }
        return false;
    }
}
