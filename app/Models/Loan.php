<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

/**
 * App\Models\Loan
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property \Illuminate\Support\Carbon $loan_date
 * @property \Illuminate\Support\Carbon|null $return_date
 * @property bool $returned
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book|null $book
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\LoanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereLoanDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereReturned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUserId($value)
 * @mixin \Eloquent
 */
class Loan extends Model
{
    use HasFactory;

    // ✅ Ajout de 'returned' au fillable
    protected $fillable = ['user_id', 'book_id', 'loan_date', 'return_date', 'returned'];

    // ✅ Cast pour les dates + le booléen
    protected $casts = [
        'loan_date' => 'datetime',
        'return_date' => 'datetime',
        'returned' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur qui emprunte le livre
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le livre emprunté
     */
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
            'returned' => ['sometimes', 'boolean'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
