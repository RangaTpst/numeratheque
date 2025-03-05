<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'loan_date', 'return_date'];

    /**
     * Cast des champs de dates pour les convertir automatiquement en objets Carbon.
     */
    protected $casts = [
        'loan_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le livre.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
