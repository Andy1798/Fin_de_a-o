<?php
namespace app\models;

use rutex\Model;
use DateTime;

class User extends Model
{
    protected $table = "users";

    protected $struct = [
        "id"           => ["required" => false],
        "name"         => ["required" => true ],
        "lastname"     => ["required" => true ],
        "phone"        => ["required" => true ],
        "mail"         => ["required" => true ],
        "password"     => ["required" => true ],
        "role"         => ["required" => false],
        "reset_token"  => ["required" => false],
        "token_expiry" => ["required" => false]
    ];

    function userLogged()
    {
        return [
            "id"        => $this->current["id"],
            "name"      => $this->current["name"],
            "lastname"  => $this->current["lastname"],
            "role"      => $this->current["role"]
        ];
    }

    public function generateResetToken()
    {
        $token  = bin2hex(random_bytes(16));
        $expiry = new DateTime("+1 hour");

        // Corregimos el uso de update() pasando el ID del usuario y el array de valores a actualizar
        $this->update($this->current["id"], [
            "reset_token" => $token,
            "token_expiry" => $expiry->format('Y-m-d H:i:s')
        ]);

        return $token;
    }

    public function findByResetToken($token)
    {
        return $this->where("reset_token", "=", $token)->select()->getFirst();
    }

    public function resetPassword($token, $newPassword)
    {
        $user = $this->findByResetToken($token);

        if ($user) {
            $expiry = new DateTime($user["token_expiry"]);
            $now = new DateTime();

            if ($expiry > $now) {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                // Actualizamos usando el ID del usuario explícitamente
                $this->update($user["id"], [
                    "password"      => $hashedPassword,
                    "reset_token"   => null,
                    "token_expiry"  => null
                ]);

                return true;
            }
        }

        return false;
    }
}
