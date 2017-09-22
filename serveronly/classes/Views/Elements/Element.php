<?php

abstract class Element implements IPrintable {

    protected $tagname;
    protected $attributes;
    protected $standalone;
    protected $innerHTML;

    protected function __construct($tagname, $attributes = array(), $standalone = true, $innerHTML = NULL) {
        $this->tagname = $tagname;
        $this->attributes = $attributes;
        $this->standalone = $standalone;
        $this->innerHTML = $innerHTML;
    }

    public function addAttribute($key, $value) {
        $this->attributes[$key] = $value;
    }

    public function setInnerHTML($innerHTML = '') {
        $this->innerHTML = $innerHTML;
    }

    public function setStandalone($standalone) {
        $this->standalone = $standalone;
    }

    public function __toString() {
        $html = '<'. $this->tagname;
        foreach ($this->attributes AS $key => $value) {
            $html .= ' '. $key .'="'. $value .'"';
        }
        if ($this->standalone) {
            $html .= ' />';
        } else {
            $html .= '>'. $this->innerHTML .'</'. $this->tagname .'>';
        }
        return $html;
    }

}