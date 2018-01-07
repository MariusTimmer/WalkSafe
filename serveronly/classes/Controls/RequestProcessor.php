<?php

namespace WalkSafe\Controls;

use Locale;

/**
 * RequestProcessor
 * This class will be called from the document classes to have a general class
 * to process incomming requests. Even if it is not a good style to call a
 * controller/processor within a view class.
 * @author Marius Timmer
 */
class RequestProcessor {

    const TEXTDOMAIN = 'escort';

    /**
     * Incomming requests will be handled by calling this method which will be
     * done in the Document. It will, for example, initiate the localization
     * according to the users browser language.
     */
    public static function init() {
        self::setupLocalization();
    }

    /**
     * Reads out the language of the users browser and continues.
     */
    protected static function setupLocalization() {
        $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $locale .= '_'. strtoupper($locale);
        self::initI18n($locale .'.UTF-8');
    }

    /**
     * Sets the localization according to the given locale.
     * @param string $locale Locale to use
     */
    private static function initI18n($locale = 'en') {
        $localedir = DIRECTORY_LOCALE;
        setlocale(LC_ALL, $locale);
        bindtextdomain(self::TEXTDOMAIN, $localedir);
        textdomain(self::TEXTDOMAIN);
    }

}
