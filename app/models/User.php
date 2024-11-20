<?php
namespace app\models;

use rutex\Model;
use DateTime;
use Exception;
class User extends Model
{
    protected $table = "users";

    protected $struct = [
        "id" => ["required" => false],
        "name" => ["required" => true],
        "lastname" => ["required" => true],
        "phone" => ["required" => true],
        "mail" => ["required" => true],
        "password" => ["required" => true],
        "role" => ["required" => false],
        "reset_code" => ["required" => false],
        "reset_code_expiry" => ["required" => false]
    ];

    function userLogged()
    {
        return [
            "id" => $this->current["id"],
            "name" => $this->current["name"],
            "lastname" => $this->current["lastname"],
            "role" => $this->current["role"]
        ];
    }

    public function generateResetCode($email)
    {
        $user = $this->where("mail", "=", $email)->select()->getFirst();

        if ($user) {
            $code = random_int(100000, 999999); 
            $expiry = new DateTime("+10 minutes"); 

            $this->update($user["id"], [
                "reset_code" => $code,
                "reset_code_expiry" => $expiry->format('Y-m-d H:i:s')
            ]);

            return $code; 
        }

        return false; 
    }

    public function verifyResetCode($email, $code)
    {
        $user = $this->where("mail", "=", $email)->select()->getFirst();

        if ($user) {
            if (!empty($user["reset_code_expiry"])) {
                try {
                    $expiry = new DateTime($user["reset_code_expiry"]);
                    $now = new DateTime();

                    if ($user["reset_code"] === $code && $expiry > $now) {
                        return $user; // Código válido
                    }
                } catch (Exception $e) {
                    error_log("Error al procesar la fecha de expiración: " . $e->getMessage());
                }
            }
        }

        return false; 
    }

    public function resetPasswordWithCode($email, $newPassword)
    {
        $user = $this->where("mail", "=", $email)->select()->getFirst();

        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            $this->update($user["id"], [
                "password" => $hashedPassword,
                "reset_code" => null,
                "reset_code_expiry" => null
            ]);

            return true; 
        }

        return false;
    }

}
