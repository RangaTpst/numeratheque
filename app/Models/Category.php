<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Valide les données d'une catégorie avant création ou mise à jour.
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public static function validateData(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZÀ-ÿ0-9\s\-]+$/'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator, $validator->errors());
        }

        return $validator->validated();
    }

    /**
     * Créer une catégorie avec validation.
     *
     * @param array $data
     * @return Category
     * @throws ValidationException
     */
    public static function createCategory(array $data)
    {
        $validatedData = self::validateData($data);
        return self::create($validatedData);
    }
}
