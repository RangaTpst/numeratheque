<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'published_at', 'category_id', 'image', 'summary'];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Vérifie si le livre est actuellement emprunté
     */
    public function isBorrowed()
    {
        return $this->loans()
            ->where(function ($query) {
                $query->whereNull('return_date')
                      ->orWhere('return_date', '>=', Carbon::now());
            })
            ->exists();
    }

    /**
     * Valide les données d'un livre avant création ou mise à jour.
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public static function validateData(array $data)
    {
        $rules = [
            'title' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\-\'\,\.\&]+$/'],
            'author' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s\-]+$/'],
            'published_at' => ['required', 'date', 'before_or_equal:' . date('Y-m-d')],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'image' => ['nullable', 'string', 'url'],
            'summary' => ['nullable', 'string', 'max:1000'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator, $validator->errors());

        }

        return $validator->validated();
    }

    /**
     * Créer un livre avec validation.
     *
     * @param array $data
     * @return Book
     * @throws ValidationException
     */
    public static function createBook(array $data)
    {
        $validatedData = self::validateData($data);
        return self::create($validatedData);
    }
}
