<?php

class GenderSelectionElement implements IPrintable {

    const GENDER_FEMALE = 0;
    const GENDER_MALE = 1;
    const GENDER_UNKNOWN = 2;
    protected $name;
    protected $value;

    public function __construct($name, $value = '') {
        $this->name = $name;
        $this->value = $value;
    }

    public function __toString() {
        $html = sprintf(
            '<fieldset><legend>%s</legend><ul style="list-style-type: none;">',
            htmlentities(gettext("LABEL_GENDER"))
        );
        $tmp = array(
            array(
                'id' => 'sel_gender_female',
                'value' => self::GENDER_FEMALE,
                'label' => gettext("GENDER_FEMALE")
            ),
            array(
                'id' => 'sel_gender_male',
                'value' => self::GENDER_MALE,
                'label' => gettext("GENDER_MALE")
            ),
            array(
                'id' => 'sel_gender_unknown',
                'value' => self::GENDER_UNKNOWN,
                'label' => gettext("LABEL_UNKNOWN")
            )
        );
        foreach ($tmp AS $index => $data) {
            $label_obj = new LabelElement($data['label'], $data['id'], true);
            $input_obj = sprintf(
                '<input type="radio" id="%s" name="%s[]" value="%d"%s/>',
                $data['id'],
                $this->name,
                $data['value'],
                ($data['value'] == $this->value) ? ' checked="checked"' : ''
            );
            $html .= '<li>'. $label_obj . $input_obj .'</li>';
        }
        $html .= '</ul></fieldset>';
        return $html;
    }

}
