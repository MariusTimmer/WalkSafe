<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Views\IPrintable;
use WalkSafe\Configuration;
use WalkSafe\Controls\RequestProcessor;
use WalkSafe\Controls\SessionManager;
use WalkSafe\Views\Elements\MainMenuElement;
use WalkSafe\Views\Documents\ErrorDocument;

abstract class Document implements IPrintable {

    protected $subtitle;
    protected $javascripts;
    protected $stylesheets;
    protected $contentelements;

    /**
     * @var MainMenuElement $mainmenu The main menu
     */
    protected $mainmenu;

    protected function __construct($subtitle, $mainmenu = NULL) {
        RequestProcessor::init();
        $this->mainmenu = new MainMenuElement();
        if (SessionManager::isLoggedIn()) {
            /**
             * Menu for the members site.
             */
            $this->mainmenu->addIcon('index.php', 'home', 'homeicon', gettext('TITLE_HOME'));
            $this->mainmenu->addIcon('myprofile.php', 'profile', 'profileicon', gettext('TITLE_MY_PROFILE'));
            $this->mainmenu->addIcon('findjob.php', 'find', 'findicon', gettext('TITLE_FIND_JOBS'));
            $this->mainmenu->addIcon('jobrequest.php', 'history', 'historyicon', gettext('TITLE_JOBREQUEST'));
            $this->mainmenu->addIcon('logout.php', 'logout', 'logouticon', gettext('TITLE_LOGOUT'));
        } else {
            /**
             * Menu for the public site.
             */
            $this->mainmenu->addLink('index.php', gettext("TITLE_START"));
            $this->mainmenu->addLink('login.php', gettext("TITLE_LOGIN"));
            $this->mainmenu->addLink('signin.php', gettext("TITLE_SIGNIN"));
        }
        $this->mainmenu->addLink('impressum.php', gettext("TITLE_IMPRESSUM"));
        $this->subtitle = $subtitle;
        $this->javascripts = array(
            'js/jquery.min.js',
            'js/escort.js'
        );
        $this->stylesheets = array(
            'css/w3mobile.css',
            'css/w3-theme-teal.css',
            'css/basic.css'
        );
        $this->contentelements = array();
        $this->readInputData();
        if ($this->allowedExecution()) {
            $this->execute();
        }
        if ($this->allowedView()) {
            $this->setupHTML();
        }
    }

    protected function readInputData() {

    }

    protected function execute() {

    }

    protected function setupHTML() {

    }

    protected function allowedExecution() {
        return true;
    }

    protected function allowedView() {
        return true;
    }

    protected function addJavascript($url) {
        array_push($this->javascripts, $url);
    }

    protected function addStylesheet($url) {
        array_push($this->stylesheets, $url);
    }

    protected function addContent($element) {
        array_push($this->contentelements, $element);
    }

    /**
     * Returns the value for the requested key from the post or get data.
     * @param string $key Key of the requested value
     * @return string Requested value or null
     */
    protected function getValue($key) {
        $input = INPUT_GET;
        if (isset($_POST[$key])) {
            $input = INPUT_POST;
        } else if (isset($_GET[$key])) {
            $input = INPUT_GET;
        }
        return filter_input($input, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function __toString() {
        if (!$this->allowedView()) {
            /**
             * The user is not allowed to see this document so
             * we only show a general permission denied page.
             */
            $title = gettext("SUBTITLE_PERMISSION_DENIED");
            $message = gettext("MESSAGE_PERMISSION_DENIED");
            $errordocument = new ErrorDocument($title, $message);
            return $errordocument->__toString();
        }
        $title = htmlentities(Configuration::get('TITLE', 'GENERAL'));
        $html  = '<!DOCTYPE html><html lang="de"><head><meta charset="UTF-8" />';
        $html .= '<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, user-scalable=no" />';
        $html .= '<title>'. htmlentities($this->subtitle) .' - '. $title .'</title>';
        foreach ($this->javascripts AS $url) {
            $html .= '<script type="text/javascript" src="'. $url .'"></script>';
        }
        foreach ($this->stylesheets AS $url) {
            $html .= '<link rel="stylesheet" href="'. $url .'" />';
        }
        $html .= '</head><body>';
        $html .= $this->mainmenu;
        $html .= '<header class="w3-top w3-bar w3-theme">';
        $html .= '<button class="w3-bar-item w3-button w3-xxxlarge w3-hover-theme" onclick="$(\'nav#sidebar\').toggle(100);">&#8801;</button>';
        $html .= '<h1 class="w3-bar-item">'. htmlentities($this->subtitle) .'</h1></header>';
        $html .= '<div id="main-container" class="w3-container" style="margin-top: 90px; margin-bottom: 60px; overflow-y: scroll;">';
        foreach ($this->contentelements AS $element) {
            $html .= '<div class="w3-cell-row"><div class="w3-cell w3-container">';
            $html .= $element;
            $html .= '</div></div>';
        }
        $html .= '</div>';
        $html .= '<footer class="w3-container w3-bottom w3-theme w3-margin-top">&copy; '. Configuration::get('COPYRIGHT', 'GENERAL') .'</footer>';
        $html .= '</body></html>';
        return $html;
    }

}
