<?php

use PHPUnit\Framework\TestCase;
use WalkSafe\Input\ServerInput;

final class InputTest extends TestCase {

    public function ServerKeyProvider() {
        return [
            ['PHP_SELF'],
            ['SCRIPT_NAME'],
            ['USER'],
            ['PATH']
        ];
    }

    /**
     * @dataProvider ServerKeyProvider
     */
    public function testCanUseInputWrapper($key) {
        $this->assertNotNull(
            ServerInput::get($key),
            'Read server variable using input wrapper class'
        );
    }

}
