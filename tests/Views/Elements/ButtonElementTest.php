<?php

use PHPUnit\Framework\TestCase;
use WalkSafe\Views\Elements\ButtonElement;

final class ButtonElementTest extends TestCase {

    public function attributeProvider() {
        return [
            ['foobar', '', '', ''],
            ['foobar', 'Next', '', ''],
            ['foobar', 'Next', 'jsfunction();', ''],
            ['foobar', '', 'jsfunction();', ''],
            ['foobar', '', '', 'some placeholder'],
            ['foobar', 'Next', '', 'some placeholder'],
            ['foobar', 'Next', 'jsfunction();', 'some placeholder'],
            ['foobar', '', 'jsfunction();', 'some placeholder'],
            ['', '', '', ''],
            ['', 'Next', '', ''],
            ['', 'Next', 'jsfunction();', ''],
            ['', '', 'jsfunction();', ''],
            ['', '', '', 'some placeholder'],
            ['', 'Next', '', 'some placeholder'],
            ['', 'Next', 'jsfunction();', 'some placeholder'],
            ['', '', 'jsfunction();', 'some placeholder']
        ];
    }

    /**
     * @dataProvider attributeProvider
     */
    public function testCanPrintElement(string $name, string $value, string $onclick, string $placeholder) {
        $button = new ButtonElement(
            'button',
            $name,
            $value,
            $onclick
        );
        $button->addAttribute('placeholder', $placeholder);
        $expectedOutput = '<input type="button" name="'. $name .'" id="'. $name .'" value="'. $value .'" placeholder="'. $placeholder .'" onclick="'. $onclick .'" />';
        $this->assertEquals(
            $expectedOutput,
            strval($button),
            'Button looks like expected'
        );
    }

}
