<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'loan_date', 'return_date'];

    protected $casts = [
        'loan_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Valide les données avant la création ou mise à jour d'un prêt.
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public static function validateData(array $data)
{
    $rules = [
        'user_id' => ['required', 'integer', 'exists:users,id'],
        'book_id' => ['required', 'integer', 'exists:books,id'],
        'loan_date' => ['required', 'date', 'before_or_equal:today'],
        'return_date' => ['nullable', 'date', 'after:loan_date'],
    ];

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
        throw new ValidationException($validator, $validator->errors());
    }

    // Vérifier si le livre est déjà emprunté sans être retourné
    if (Loan::where('book_id', $data['book_id'])->whereNull('return_date')->exists()) {
        throw ValidationException::withMessages([
            'book_id' => ['This book is already loaned and not returned yet.']
        ]);
    }

    return $validator->validated();
}


    /**
     * Créer un prêt avec validation.
     *
     * @param array $data
     * @return Loan
     * @throws ValidationException
     */
    public static function createLoan(array $data)
    {
        $validatedData = self::validateData($data);
        return self::create($validatedData);
    }
}
