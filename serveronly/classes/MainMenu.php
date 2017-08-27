<?php

class MainMenu extends Element {

    const DEFAULT_TITLE = 'Main menu';

    protected $title;
    protected $links;

    /**
     * Creates a new instance of a main menu.
     * @param string $title Title of the main menu
     */
    public function __construct($title = self::DEFAULT_TITLE) {
        $this->title = $title;
        $this->links = array();
    }

    public function addIcon($url, $icon, $id = '', $alternative = '') {
        $this->links[$url] = (object) array(
            'type' => 'iconlink',
            'id' => $id,
            'alternative' => $alternative,
            'icon' => $icon
        );
    }

    /**
     * Adds a new item to the link list.
     * @param string $url URL of the item
     * @param string $title Title of the item
     */
    public function addLink($url, $title) {
        $this->links[$url] = (object) array(
            'type' => 'textlink',
            'title' => $title
        );
    }

    public function __toString() {
        $html  = '<nav class="w3-sidebar w3-bar-block w3-card" id="sidebar">';
        $html .= '<div class="w3-container w3-theme-d2">';
        $html .= '<span onclick="$(\'nav#sidebar\').fadeOut(100);" class="w3-button w3-display-topright w3-large">X</span>';
        $html .= '<br /><div class="w3-padding w3-center">';
        $html .= '<h3>'. htmlentities($this->title) .'</h3>';
        $html .= '</div></div><div id="mainmenu_links">';
        foreach ($this->links AS $url => $data) {
            $innerHTML = '';
            if ($data->type === 'iconlink') {
                $innerHTML = new IconElement($data->icon, $data->id, $data->alternative);
            } else if ($data->type === 'textlink') {
                $innerHTML = htmlentities($data->title);
            }
            $html .= '<a class="w3-bar-item w3-button" target="_self" href="'. $url .'">'. $innerHTML .'</a>';
        }
        $html .= '</div></nav>';
        $html .= '<script type="text/javascript">document.getElementById("sidebar").style = "display: none";</script>';
        return $html;
    }

}
