<?php

require_once('/srv/escort/autoload.php');
if (SessionManager::isLoggedIn()) {
    /**
     * The user is logged in in the current session so we will show
     * the home document for the user.
     */
    $document = new HomeDocument();
} else {
    /**
     * The user is not logged in so we show the regular public start site.
     */
    $document = new StartDocument();
}
print $document;
