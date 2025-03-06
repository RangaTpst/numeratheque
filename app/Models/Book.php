<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'published_at', 'category_id', 'image','summary'];

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
}
