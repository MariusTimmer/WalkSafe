<?php

namespace WalkSafe\Input;

/**
 * Get Input class
 * A basic class for input data read from the get variable.
 * @author Marius Timmer
 */
class GetInput extends BasicInput {

    protected static function getData(): array {
        return $_GET;
    }

}
