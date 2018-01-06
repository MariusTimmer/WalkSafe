<?php

namespace WalkSafe;

use WalkSafe\ServerConfiguration;

abstract class EMail {

    protected $from;
    protected $to;
    protected $serverconfiguration;

    public function __construct($to) {
        $this->serverconfiguration = new ServerConfiguration();
        $this->to = $to;
        $this->from = sprintf(
            '%s <%s>',
            $this->serverconfiguration->getTitle(),
            $this->serverconfiguration->getSystemAddress()
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
