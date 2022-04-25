<?php


namespace App\db;

use App\service\UsersService;
use Lib\Cookie\Cookie;

/**
 * Class Auth
 * @package App\db
 */
class Auth
{
    /**
     * @return bool
     */
    public static function isAuth()
    {
        $userService = new UsersService();
        if (!is_null(self::id())) {
            $user = $userService->find(self::id(), ['id', 'remember_token']);
            if (!empty($user)) {
                return Cookie::getCookie('remember_token') === $user['remember_token'];
            }
        }

        return false;
    }

    /**
     * @return int|null
     */
    public static function id()
    {
        return is_null(Cookie::getCookie('user_id')) ? null : (int)Cookie::getCookie('user_id');
    }

    /**
     * @param int $len
     * @param string $str
     * @return string
     */
    public static function uuid(int $len = 10, string $str = ''): string
    {
        $str .= uniqid();

        if (mb_strlen($str) > $len) {
            return mb_substr($str, 0, $len);
        }

        return self::uuid($len, $str);
    }
}