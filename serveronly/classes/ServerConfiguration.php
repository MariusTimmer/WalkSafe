<?php

namespace WalkSafe;

class ServerConfiguration extends Configuration {

    const FILENAME = SERVERONLY_ROOT . DIRECTORY_SEPARATOR .'server.json';
    const KEY_TITLE = 'sitetitle';
    const KEY_FQDN = 'fqdn';
    const KEY_SYSTEM_ADDRESS = 'systemaddress';
    const KEY_COPYRIGHT = 'copyright';
    const KEY_RESPONSIBLE = 'responsible';
    const KEY_IMPRESSUM_PERSONNAME = 'impressum_personname';
    const KEY_IMPRESSUM_STREET = 'impressum_street';
    const KEY_IMPRESSUM_CITY = 'impressum_city';
    const KEY_IMPRESSUM_EMAIL = 'impressum_email';

    public function __construct() {
        parent::__construct(self::FILENAME);
    }

    public static function exists() {
        if (!file_exists(self::FILENAME)) {
            return false;
        }
        $serverConfiguration = new ServerConfiguration(self::FILENAME);
        return !empty($serverConfiguration->getTitle());
    }

    public function getTitle() {
        return $this->getValue(self::KEY_TITLE);
    }

    public function getFQDN() {
        return $this->getValue(self::KEY_FQDN);
    }

    public function getSystemAddress() {
        return $this->getValue(self::KEY_SYSTEM_ADDRESS);
    }

    public function getCopyright() {
        return $this->getValue(self::KEY_COPYRIGHT);
    }

    public function getResponsible() {
        return $this->getValue(self::KEY_RESPONSIBLE);
    }

    public function getImpressumPersonname() {
        return $this->getValue(self::KEY_IMPRESSUM_PERSONNAME);
    }

    public function getImpressumStreet() {
        return $this->getValue(self::KEY_IMPRESSUM_STREET);
    }

    public function getImpressumCity() {
        return $this->getValue(self::KEY_IMPRESSUM_CITY);
    }

    public function getImpressumEmail() {
        return $this->getValue(self::KEY_IMPRESSUM_EMAIL);
    }

}
