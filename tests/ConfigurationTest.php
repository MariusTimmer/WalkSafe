<?php

use PHPUnit\Framework\TestCase;
use WalkSafe\Configuration;

final class ConfigurationTest extends TestCase {

    public function keysAndSectionsProvider() {
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
            ],
            [
                'DATABASE',
                [
                    'TYPE',
                    'HOSTNAME',
                    'DATABASENAME',
                    'USERNAME',
                    'PASSWORDFILE'
                ]
            ],
            [
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
     * Moving the configuration file showed the expected effects.
     * Determinating a available configuration succeed.
     */
    public function testExisting() {
        $backupFilename = Configuration::CONFIGURATIONFILE .'_BU';
	$this->assertFileExists(
            Configuration::CONFIGURATIONFILE,
            'Existing initial configuration file'
        );
        $this->assertFalse(
            Configuration::exists(),
            'Initial configuration file is empty'
        );
        $this->assertNotNull(
            Configuration::get('TITLE', 'GENERAL'),
            'Initial value is set'
        );
        $this->assertEmpty(
            Configuration::get('TITLE', 'GENERAL'),
            'Initial value is empty but set'
        );
        $this->assertTrue(
            rename(
                Configuration::CONFIGURATIONFILE,
                $backupFilename
            ),
            'Moving initial configuration file'
        );
	$this->assertFileExists(
            $backupFilename,
            'Existing backup configuration file'
        );
        $this->assertFalse(
            Configuration::exists(),
            'Moving the configuration file caused not existing configuration'
        );
        $this->assertTrue(
            rename(
                $backupFilename,
                Configuration::CONFIGURATIONFILE
            ),
            'Moved configuration file restored'
        );
        $this->assertFalse(
            Configuration::exists(),
            'Restored configuration file is empty'
        );
    }

    /**
     * @dataProvider keysAndSectionsProvider
     */
    public function testCanUseInputWrapper(string $section, array $keys) {
        foreach ($keys AS $key) {
            $configPath = $section .'::'. $key;
            $this->assertNotNull(
                Configuration::get($key, $section),
                sprintf(
                    'Key "%s" in section "%s" is set',
                    $key,
                    $section
                )
            );
            $this->assertEmpty(
                Configuration::get($key, $section),
                sprintf(
                    'Key "%s" in section "%s" has the expected value',
                    $key,
                    $section
                )
            );
            $this->assertNotNull(
                Configuration::get($configPath),
                sprintf(
                    'Value for path "%s" is set',
                    $configPath
                )
            );
            $this->assertEmpty(
                Configuration::get($configPath),
                sprintf(
                    'Expected value for path "%s"',
                    $configPath
                )
            );
        }
    }

}
