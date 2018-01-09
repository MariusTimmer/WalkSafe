<?php

namespace WalkSafe\Input;

/**
 * Post Input class
 * A basic class for input data read from the post variable.
 * @author Marius Timmer
 */
class PostInput extends BasicInput {

    protected static function getData(): array {
        return $_POST;
    }

}
