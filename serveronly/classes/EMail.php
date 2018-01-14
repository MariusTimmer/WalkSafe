<?php

namespace WalkSafe;

use WalkSafe\Configuration;

abstract class EMail {

    protected $from;
    protected $to;

    public function __construct($to) {
        $this->to = $to;
        $this->from = sprintf(
            '%s <%s>',
            Configuration::get('TITLE', 'GENERAL'),
            Configuration::get('SYSTEMADDRESS', 'GENERAL')
        );
    }

    abstract protected function getContent();
    abstract protected function getSubject();

    protected function getHeaders() {
        return array(
            'MIME-Version: 1.0',
            'From: '. $this->from,
            'Content-Type: text/plain; charset=UTF-8',
            'Bcc: '. $this->from
        );
    }

    public function send() {
        if (is_array($this->to)) {
            $this->to = implode(', ', $this->to);
        }
        $headers = implode("\r\n", $this->getHeaders());
        $message = wordwrap($this->getContent(), 70);
        return mail($this->to, $this->getSubject(), $message, $headers);
    }

}
