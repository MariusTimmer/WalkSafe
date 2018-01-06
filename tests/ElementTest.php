<?php

use WalkSafe\Views\Elements\TextElement;

final class ElementTest extends PHPUnit_Framework_TestCase {

    public function testCanPrintTextElement() {
        $text = 'FooBar';
        $textElement = new TextElement($text);
        $this->assertTrue(
            is_string(strval($textElement)),
            'can be converted to string'
        );
        $this->assertNotEmpty(
            strval($textElement),
            'HTML is not empty'
        );
        $this->assertEquals(
            '<p>'. $text .'</p>',
            strval($textElement),
            'TextElement looks like expected'
        );
    }

}
