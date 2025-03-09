<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Valide les données d'un utilisateur avant création ou mise à jour.
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public static function validateData(array $data)
{
    $rules = [
        'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZÀ-ÿ\s\-]+$/'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
    ];

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
        throw new ValidationException($validator, $validator->errors());
    }

    // Vérification manuelle de l'unicité de l'email avant insertion
    if (User::where('email', $data['email'])->exists()) {
        throw ValidationException::withMessages([
            'email' => ['The email has already been taken.']
        ]);
    }

    return $validator->validated();
}


    /**
     * Créer un utilisateur avec validation.
     *
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public static function createUser(array $data)
    {
        $validatedData = self::validateData($data);
        return self::create($validatedData);
    }
}
