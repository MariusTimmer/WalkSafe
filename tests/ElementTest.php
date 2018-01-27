<?php

use PHPUnit\Framework\TestCase;
use WalkSafe\Views\Elements\TextElement;

final class ElementTest extends TestCase {

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
            '<div><p>'. $text .'</p></div>',
            strval($textElement),
            'TextElement looks like expected'
        );
    }

}
