<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

/**
 * Class Book
 *
 * @property int $id
 * @property string $title
 * @property string $author
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string|null $image
 * @property string|null $summary
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 *
 * @method static \Database\Factories\BookFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'published_at',
        'image',
        'summary',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    /**
     * Chaque livre appartient à une seule catégorie.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Un livre peut avoir plusieurs prêts.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Vérifie si le livre est actuellement emprunté.
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
     * Vérifie si le livre peut être supprimé.
     *
     * @throws ValidationException
     */
    public function canBeDeleted()
    {
        if ($this->isBorrowed()) {
            throw ValidationException::withMessages([
                'error' => 'Ce livre est actuellement emprunté et ne peut pas être supprimé.'
            ]);
        }
    }
}
