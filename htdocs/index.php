<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'ServerConnector.php');
if (!\WalkSafe\ServerConfiguration::exists()) {
    /**
     * There is no server configuration set. In this case we can assume that
     * the system is not set up yet and therefore the installation formular
     * will be used instead of the normal "home" or index document.
     */
    $document = new \WalkSafe\Views\Documents\InstallDocument();
} else if (\WalkSafe\Controls\SessionManager::isLoggedIn()) {
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
