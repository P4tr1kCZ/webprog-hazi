<?php

class Localization
{
    private $messages;

    const DEFAULT_LANGUAGE = "en";
    const CURRENT_LANGUAGE_SESSION_VAR = "__currentlang__";

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION[self::CURRENT_LANGUAGE_SESSION_VAR])) {
            $this->setLanguage(
                $_SESSION[self::CURRENT_LANGUAGE_SESSION_VAR]
            );
        } else {
            $this->setLanguage(self::DEFAULT_LANGUAGE);
        }
    }

    public function setLanguage($language)
    {
        include(__DIR__ . "/../view/messages/messages_$language.php");
        $this->messages = $i18n_messages;

        $_SESSION[self::CURRENT_LANGUAGE_SESSION_VAR] = $language;
    }

    public function i18n($key)
    {
        if (isset($this->messages[$key])) {
            return $this->messages[$key];
        } else {
            return $key;
        }
    }

    private static $i18n_singleton = null;

    public static function getInstance()
    {
        if (self::$i18n_singleton == NULL) {
            self::$i18n_singleton = new Localization();
        }
        return self::$i18n_singleton;
    }

    public function getAllMessages()
    {
        return $this->messages;
    }
}

function i18n($key)
{
    return Localization::getInstance()->i18n($key);
}
