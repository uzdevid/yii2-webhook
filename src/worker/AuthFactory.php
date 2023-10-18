<?php

namespace uzdevid\webhook\worker;

use yii\base\NotSupportedException;

class AuthFactory {
    public static function create(string $type, array $params): Auth {
        $className = 'uzdevid\\webhook\\worker\\auths\\' . ucfirst($type);

        if (!class_exists($className)) {
            throw new NotSupportedException("Auth type \"{$type}\" is not supported");
        }

        return new $className($params);
    }
}