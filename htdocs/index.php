<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'ServerConnector.php');
if (\WalkSafe\Controls\SessionManager::isLoggedIn()) {
    /**
     * The user is logged in in the current session so we will show
     * the home document for the user.
     */
    $document = new \WalkSafe\Views\Documents\HomeDocument();
} else {
    /**
     * The user is not logged in so we show the regular public start site.
     */
    $document = new \WalkSafe\Views\Documents\StartDocument();
}
print $document;
