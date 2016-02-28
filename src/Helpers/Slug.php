<?php namespace Crip\Core\Helpers;

/**
 * Class Slug
 * @package Crip\Core\Helpers
 */
class Slug
{
    /**
     * @var array
     */
    private static $ascii = array(
        '/�|�/' => 0,
        '/�/' => 1,
        '/�/' => 2,
        '/�/' => 3,
        '/�|?|�/' => 'ae',
        '/�|�/' => 'oe',
        '/�|�|�|�|�|?|?|?|?|?|?/' => 'A',
        '/�|�|�|�|�|?|?|?|?|?|�|?/' => 'a',
        '/@/' => 'at',
        '/?/' => 'B',
        '/?/' => 'b',
        '/�|?|?|?|?|?/' => 'C',
        '/�|?|?|?|?|?/' => 'c',
        '/�|?|?|?/' => 'Dj',
        '/�|?|?|?/' => 'dj',
        '/�|�|�|�|?|?|?|?|?|?|?|?/' => 'E',
        '/�|�|�|�|?|?|?|?|?|?|?|?/' => 'e',
        '/?/' => 'F',
        '/�|?/' => 'f',
        '/?|?|?|?|?/' => 'G',
        '/?|?|?|?|?/' => 'g',
        '/?|?|?/' => 'H',
        '/?|?|?/' => 'h',
        '/�|�|�|�|?|?|?|?|?|?|?/' => 'I',
        '/�|�|�|�|?|?|?|?|?|?|?/' => 'i',
        '/?|?/' => 'J',
        '/?|?/' => 'j',
        '/?|?/' => 'K',
        '/?|?/' => 'k',
        '/?|?|?|?|?|?/' => 'L',
        '/?|?|?|?|?|?/' => 'l',
        '/?/' => 'M',
        '/?/' => 'm',
        '/�|?|?|?|?/' => 'N',
        '/�|?|?|?|?|?/' => 'n',
        '/�|�|�|�|?|?|?|?|?|�|?|?/' => 'O',
        '/�|�|�|�|?|?|?|?|?|�|?|�|?/' => 'o',
        '/?/' => 'P',
        '/?/' => 'p',
        '/?|?|?|?/' => 'R',
        '/?|?|?|?/' => 'r',
        '/?|?|?|?|�|?/' => 'S',
        '/?|?|?|?|�|?|?/' => 's',
        '/?|?|?|?|?/' => 'T',
        '/?|?|?|?|?/' => 't',
        '/�|�|�|?|?|?|?|?|?|?|?|?|?|?|?|?/' => 'U',
        '/�|�|�|?|?|?|?|?|?|?|?|?|?|?|?|?/' => 'u',
        '/�/' => 'ue',
        '/�/' => 'UE',
        '/?/' => 'V',
        '/?/' => 'v',
        '/�|�|?|?/' => 'Y',
        '/�|�|?|?/' => 'y',
        '/?/' => 'W',
        '/?/' => 'w',
        '/?|?|�|?/' => 'Z',
        '/?|?|�|?/' => 'z',
        '/�|?|�/' => 'AE',
        '/�/' => 'ss',
        '/?/' => 'IJ',
        '/?/' => 'ij',
        '/�|�/' => 'OE',
        '/?/' => 'Ch',
        '/?/' => 'ch',
        '/?/' => 'Ju',
        '/?/' => 'ju',
        '/?/' => 'Ja',
        '/?/' => 'ja',
        '/?/' => 'Sh',
        '/?/' => 'sh',
        '/?/' => 'Shch',
        '/?/' => 'shch',
        '/?/' => 'Zh',
        '/?/' => 'zh',
    );

    /**
     * Converts string from special characters to URL friendly string
     *
     * @param string $string String co covert
     * @param string $separator Separator to replace spaces
     * @param null $emptyValue Return value if target result is empty
     *
     * @return string URL friendly string
     */
    public static function make($string, $separator = '-', $emptyValue = null)
    {
        $string = preg_replace('/
                    [\x09\x0A\x0D\x20-\x7E]            # ASCII
                  | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
                  |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
                  | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
                  |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
                  |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
                  | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
                  |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
               /', '', $string);
        $string = static::translateByArray($string);
        $string = preg_replace('#[^\\pL\d]+#u', $separator, $string);
        $string = trim($string, $separator);
        $string = (defined('MB_CASE_LOWER')) ? mb_strtolower($string) : strtolower($string);
        $string = preg_replace('#[^-\w]+#', '', $string);
        if ($string === '') {
            return $emptyValue ?: 'n' . $separator . 'a';
        }

        return $string;
    }

    /**
     * Replace special characters with english chars
     *
     * @param string $string String co covert
     *
     * @return string English char string
     */
    public static function translateByArray($string)
    {
        return preg_replace(array_keys(self::$ascii), array_values(self::$ascii), $string);
    }
}