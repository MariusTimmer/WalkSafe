<?php

use PHPUnit\Framework\TestCase;
use WalkSafe\Views\Elements\ErrorMessageElement;

final class ErrorMessageElementTest extends TestCase {

    public function attributeProvider() {
        $text = 'Message to print';
        $title = 'Error';
        return [
            [$text, ''],
            [$text, $title],
            ['', $title]
        ];
    }

    /**
     * @dataProvider attributeProvider
     */
    public function testCanPrintElement(string $text, string $title) {
        $element = new ErrorMessageElement($text, $title);
        $expectedOutput = '<div class="errormessage">';
        if (!empty($title)) {
            $expectedOutput .= '<b>'. $title .'</b>';
        }
        $expectedOutput .= '<p>'. $text .'</p></div>';
        $this->assertEquals(
            $expectedOutput,
            strval($element),
            'Element looks like expected'
        );
    }

}
