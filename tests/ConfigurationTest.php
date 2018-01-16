<?php

use PHPUnit\Framework\TestCase;
use WalkSafe\Configuration;

final class ConfigurationTest extends TestCase {

    public function sectionKeyProvider() {
        return [
            [
                'GENERAL',
                [
                    'TITLE',
                    'FQDN',
                    'SYSTEMADDRESS',
                    'COPYRIGHT',
                    'RESPONSIBLE'
                ]
            ], [
                'DATABASE',
                [
                    'TYPE',
                    'HOSTNAME',
                    'DATABASENAME',
                    'USERNAME',
                    'PASSWORDFILE'
                ]
            ], [
                'IMPRESSUM',
                [
                    'PERSON',
                    'STREET',
                    'CITY',
                    'EMAIL'
                ]
            ]
        ];
    }

    /**
     * @dataProvider sectionKeyProvider
     */
    public function testInitialKeysReadable(string $section, array $keys) {
        foreach ($keys AS $key) {
            $this->assertNotNull(
                Configuration::get($key, $section),
                'read value by section and key separated'
            );
            $this->assertNotNull(
                Configuration::get($section .'::'. $key),
                'read value by section and key as path'
            );
        }
        $this->assertNull(
            Configuration::get('bar', 'foo'),
            'Invalid paths not readable'
        );
    }

    public function testCanDeterminateIfExists() {
        $this->assertFalse(
            Configuration::exists(),
            'Initial configuration is empty'
        );
        $this->assertTrue(
            Configuration::set('TITLE', 'GENERAL', 'fooBar'),
            'Set general title'
        );
        $this->assertTrue(
            Configuration::exists(),
            'Set title made configuration existing'
        );
        $this->assertTrue(
            Configuration::set('TITLE', 'GENERAL', null),
            'Set value removed'
        );
        $this->assertFalse(
            Configuration::exists(),
            'Configuration does not exists anymore after removing title'
        );
    }

    /**
     * @dataProvider sectionKeyProvider
     */
    public function testCanModify(string $section, array $keys) {
        $filebackup = Configuration::CONFIGURATIONFILE .'_BU';
        $this->assertTrue(
            rename(Configuration::CONFIGURATIONFILE, $filebackup),
            'Backup original file'
        );
        foreach ($keys AS $key) {
            $origValue = Configuration::get($key, $section);
            $this->assertTrue(
                Configuration::set($key, $section, 'foobar'),
                'Set new value'
            );
            $this->assertNotEquals(
                $origValue,
                Configuration::get($key, $section),
                'New value available'
            );
        }
        $this->assertTrue(
            Configuration::store(),
            'Confirming storing new configuration'
        );
        $this->assertNotEquals(
            md5_file(Configuration::CONFIGURATIONFILE),
            md5_file($filebackup),
            'New and original configuration is different'
        );
        $this->assertTrue(
            rename($filebackup, Configuration::CONFIGURATIONFILE),
            'Restored original configuration file'
        );
    }

}
