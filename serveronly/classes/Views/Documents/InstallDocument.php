<?php

namespace WalkSafe\Views\Documents;

use WalkSafe\Configuration;
use WalkSafe\Input\PostInput;
use WalkSafe\Views\Documents\PublicDocument;
use WalkSafe\Views\Elements\SelectElement;
use WalkSafe\Views\Elements\SubmitElement;
use WalkSafe\Views\Elements\FormElement;
use WalkSafe\Views\Elements\TextElement;
use WalkSafe\Views\Elements\LabeledTextInputElement;
use WalkSafe\Views\Elements\LabelElement;

class InstallDocument extends PublicDocument {

    const KEY_TITLE = 'title';
    const KEY_FQDN = 'fqdm';
    const KEY_SYSADDRESS = 'sysaddress';
    const KEY_COPYRIGHT = 'copyright';
    const KEY_RESPONSIBLE = 'responsible';
    const KEY_DATABASE_TYPE = 'db_type';
    const KEY_DATABASE_HOSTNAME = 'db_hostname';
    const KEY_DATABASE_DATABASENAME = 'db_dbname';
    const KEY_DATABASE_USERNAME = 'db_username';
    const KEY_DATABASE_PASSWORDFILE = 'db_passwordfile';
    const KEY_IMPRESSUM_PERSONNAME = 'imp_personname';
    const KEY_IMPRESSUM_STREET = 'imp_street';
    const KEY_IMPRESSUM_CITY = 'imp_city';
    const KEY_IMPRESSUM_EMAIL = 'imp_email';
    const KEY_SUBMIT = 'submit';

    const DATABASE_TYPE_MYSQL = 'mysql';
    const DATABASE_TYPE_POSTGRES = 'postgres';

    const MODE_DATAINPUT = 1;
    const MODE_STOREDATA = 2;

    /**
     *
     * @var bool
     */
    private $currentMode;

    private $storedSuccessfully;

    function __construct() {
        parent::__construct(gettext("Installation"));
    }

    protected function readInputData() {
        parent::readInputData();
        $this->storedSuccessfully = false;
        if (empty(PostInput::get(self::KEY_SUBMIT))) {
            /**
             * Submit button was not pressed so we can assume that the user
             * wants to put in the data and we are currently at step 1.
             */
            $this->currentMode = self::MODE_DATAINPUT;
        } else {
            /**
             * The submit button was pressed so we can assume the data is given
             * in the post and can be stored now. In case of an error we will
             * bring the formular again.
             */
            $this->currentMode = self::MODE_STOREDATA;
        }
    }

    protected function execute() {
        if ($this->currentMode == self::MODE_STOREDATA) {
            if (!$this->validateInputData()) {
                /**
                 * The given input data could not be validated successfully
                 * which means we will brin up the formular again and a error
                 * message.
                 */
                $this->addContent(
                    new TextElement(
                        gettext("Could not validate the given data successfully"),
                        gettext("Error")
                    )
                );
                return;
            }
            $this->storedSuccessfully = $this->storeNewConfiguration();
            if (!$this->storedSuccessfully) {
                /**
                 * In case the flag is still false we were not able to write
                 * the new configuration file. We should print out this kind
                 * of serious error.
                 */
                $this->addContent(
                    new TextElement(
                        gettext("Could not write the new configuration file"),
                        gettext("Error")
                    )
                );
            }
        }
    }

    protected function setupHTML() {
        if (($this->currentMode === self::MODE_DATAINPUT) ||
            (!$this->storedSuccessfully)) {
            /**
             * Bring up the formular because the user did not do it yet
             * or because the given data couldnt be validated / stored.
             */
            $this->buildInputFormular();
        } else {
            /**
             * At this point we can be pretty sure that the new configuration
             * has been written to the server and we can inform the user.
             */
            $this->addContent(
                new TextElement(
                    gettext("The new configuration has been written to the server successfully"),
                    gettext("Success")
                )
            );
        }
    }

    /**
     * Writes the post data to the config and stores it into the config file.
     * @return bool True on success or false on failure
     */
    private function storeNewConfiguration(): bool {
        foreach (self::getRequiredPostKeysAsArray() AS $postkey => $config) {
            Configuration::set(
                $config['key'],
                $config['section'],
                PostInput::get($postkey)
            );
        }
        return Configuration::store();
    }

    /**
     * Validates the from the user given data.
     * @return bool True if the data seems to be correct or false
     */
    private function validateInputData(): bool {
        foreach (array_keys(self::getRequiredPostKeysAsArray()) AS $key) {
            if (empty(PostInput::get($key))) {
                return false;
            }
        }
        $dbtype = PostInput::get(self::KEY_DATABASE_TYPE);
        if (($dbtype !== self::DATABASE_TYPE_MYSQL) &&
            ($dbtype !== self::DATABASE_TYPE_POSTGRES)) {
            /**
             * Selected database type is not supported. Maybe the user changed
             * the values of the selectbox or something else). We do not accept
             * other values for database types.
             */
            return false;
        }
        return true;
    }

    /**
     * Just returns the post keys of the required data as an array.
     * @return array
     */
    private static function getRequiredPostKeysAsArray() {
        return array(
            self::KEY_TITLE => array(
                'section' => 'GENERAL',
                'key' => 'TITLE'
            ),
            self::KEY_FQDN => array(
                'section' => 'GENERAL',
                'key' => 'FQDN'
            ),
            self::KEY_SYSADDRESS => array(
                'section' => 'GENERAL',
                'key' => 'SYSTEMADDRESS'
            ),
            self::KEY_COPYRIGHT => array(
                'section' => 'GENERAL',
                'key' => 'COPYRIGHT'
            ),
            self::KEY_RESPONSIBLE => array(
                'section' => 'GENERAL',
                'key' => 'RESPONSIBLE'
            ),
            self::KEY_DATABASE_TYPE => array(
                'section' => 'DATABASE',
                'key' => 'TYPE'
            ),
            self::KEY_DATABASE_HOSTNAME => array(
                'section' => 'DATABASE',
                'key' => 'HOSTNAME'
            ),
            self::KEY_DATABASE_DATABASENAME => array(
                'section' => 'DATABASE',
                'key' => 'DATABASENAME'
            ),
            self::KEY_DATABASE_USERNAME => array(
                'section' => 'DATABASE',
                'key' => 'USERNAME'
            ),
            self::KEY_DATABASE_PASSWORDFILE => array(
                'section' => 'DATABASE',
                'key' => 'PASSWORDFILE'
            ),
            self::KEY_IMPRESSUM_PERSONNAME => array(
                'section' => 'IMPRESSUM',
                'key' => 'PERSON'
            ),
            self::KEY_IMPRESSUM_STREET => array(
                'section' => 'IMPRESSUM',
                'key' => 'STREET'
            ),
            self::KEY_IMPRESSUM_CITY => array(
                'section' => 'IMPRESSUM',
                'key' => 'CITY'
            ),
            self::KEY_IMPRESSUM_EMAIL => array(
                'section' => 'IMPRESSUM',
                'key' => 'EMAIL'
            )
        );
    }

    /**
     * This method does exactly what the name says.
     */
    private function buildInputFormular() {
        $formContent  = new TextElement(
            sprintf(
                gettext("We have noticed that your system is not configured yet. Now we reached the point you need to configure it. Just fill out the following formular and confirm your input data clicking the submit button. To revert or change your configuration you can edit the \"%s\" file at any time."),
                sprintf(
                    '<code>%s</code>',
                    Configuration::CONFIGURATIONFILE
                )
            )
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Title"),
            self::KEY_TITLE,
            PostInput::get(self::KEY_TITLE)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Fully qualified domain name"),
            self::KEY_FQDN,
            PostInput::get(self::KEY_FQDN)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("System address"),
            self::KEY_SYSADDRESS,
            PostInput::get(self::KEY_SYSADDRESS)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Copyright"),
            self::KEY_COPYRIGHT,
            PostInput::get(self::KEY_COPYRIGHT)
        );
        // Database stuff
        $formContent .= '<fieldset><legend>'. gettext("Database") .'</legend>';
        $formContent .= new LabelElement(gettext("Type"), self::KEY_DATABASE_TYPE);
        $formContent .= new SelectElement(
            self::KEY_DATABASE_TYPE,
            array(
                self::DATABASE_TYPE_MYSQL => gettext("MySQL"),
                self::DATABASE_TYPE_POSTGRES => gettext("PostgreSQL")
            ),
            '',
            PostInput::get(self::KEY_DATABASE_TYPE)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Hostname"),
            self::KEY_DATABASE_HOSTNAME,
            PostInput::get(self::KEY_DATABASE_HOSTNAME)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Database name"),
            self::KEY_DATABASE_DATABASENAME,
            PostInput::get(self::KEY_DATABASE_DATABASENAME)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Username"),
            self::KEY_DATABASE_USERNAME,
            PostInput::get(self::KEY_DATABASE_USERNAME)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Password file"),
            self::KEY_DATABASE_PASSWORDFILE,
            PostInput::get(self::KEY_DATABASE_PASSWORDFILE)
        );
        $formContent .= '</fieldset>';
        // Impressum stuff (required for legal reasons in some countries)
        $formContent .= '<fieldset><legend>'. gettext("Impressum") .'</legend>';
        $formContent .= new LabeledTextInputElement(
            gettext("Responsible"),
            self::KEY_RESPONSIBLE,
            PostInput::get(self::KEY_RESPONSIBLE)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Person"),
            self::KEY_IMPRESSUM_PERSONNAME,
            PostInput::get(self::KEY_IMPRESSUM_PERSONNAME)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Street"),
            self::KEY_IMPRESSUM_STREET,
            PostInput::get(self::KEY_IMPRESSUM_STREET)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("City"),
            self::KEY_IMPRESSUM_CITY,
            PostInput::get(self::KEY_IMPRESSUM_CITY)
        );
        $formContent .= new LabeledTextInputElement(
            gettext("Email"),
            self::KEY_IMPRESSUM_EMAIL,
            PostInput::get(self::KEY_IMPRESSUM_EMAIL)
        );
        $formContent .= '</fieldset>';
        $formContent .= new SubmitElement(
            self::KEY_SUBMIT,
            gettext("Save")
        );
        $formular = new FormElement('', $formContent);
        $this->addContent($formular);
    }

}