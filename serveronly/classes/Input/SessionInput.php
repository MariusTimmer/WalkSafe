<?php

namespace WalkSafe\Input;

/**
 * Session Input class
 * A basic class for input data read from the session variable.
 * @author Marius Timmer
 */
class SessionInput extends BasicInput {

    protected static function getData(): array {
        return $_SESSION;
    }

}
