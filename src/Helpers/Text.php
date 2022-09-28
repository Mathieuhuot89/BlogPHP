<?php
namespace App\Helpers;

class Text {

    public static function excerpt(string $content, int $limit = 60)
    {
        if (strlen($content) <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit); // trouve une 'espace' apres la limite
        return mb_substr($content, 0, $lastSpace) . ' ... ';
    }

}