<?php

namespace app\entities\users\providers;


use Firebase\JWT\JWT;
use yii\web\Request;

class JWTProvider
{
    /**
     * Генерируем JWT
     * @param int $user_id
     * @param string $name
     * @param int $jwt_expire
     * @return array
     */
    public static function getJWT(int $user_id, string $name, int $jwt_expire = 43200)
    {
        // Данные
        $secret      = static::getSecretKey();
        $currentTime = time();
        $expire      = $currentTime + $jwt_expire;
        $request     = \Yii::$app->request;
        $hostInfo    = '';
        // Проверяем объект
        if ($request instanceof Request)
            $hostInfo = $request->hostInfo;

        // Информация токена
        $token = [
            'jti' => $user_id,
            'iat' => $currentTime,
            'iss' => $hostInfo,
            'aud' => $hostInfo,
            'nbf' => $currentTime,
            'exp' => $expire,
            'data' => [
                'name' => $name
            ]
        ];

        return JWT::encode($token, $secret, static::getAlgo());
    }

    /**
     * Возвращаем ID пользователя по JWT токену
     * @param $token
     * @param null $type
     * @return bool|mixed
     */
    public static function getUserIdByToken($token, $type = null)
    {
        try {
            // Секретный ключ
            $secret  = self::getSecretKey();
            // Декодируем и переводим в массив
            $decoded = (array) JWT::decode($token, $secret, [static::getAlgo()]);

            if (is_array($decoded) && isset($decoded['jti'])) {
                // Проверка на время жизни
                if ($decoded['exp'] > time())
                    return $decoded['jti'];
            }

            return false;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Секретный ключ
     * @return string
     */
    protected static function getSecretKey()
    {
        // TODO
        return '1234567890';
    }

    /**
     * Алгоритм шифрования
     * @return string
     */
    protected static function getAlgo()
    {
        return 'HS256';
    }
}