<?php

namespace WalkSafe\Input;

/**
 * Server Input class
 * A basic class for input data read from the server variable.
 * @author Marius Timmer
 */
class ServerInput extends BasicInput {

    protected static function getData(): array {
        return $_SERVER;
    }

}
