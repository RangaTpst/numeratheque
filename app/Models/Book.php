<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $author
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string|null $image
 * @property string|null $summary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Loan> $loans
 * @property-read int|null $loans_count
 * @method static \Database\Factories\BookFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'published_at', 'image', 'summary'];

    protected $casts = [
        'published_at' => 'date',
    ];

    /**
     * Relation Many-to-Many avec les catégories
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    /**
     * Relation One-to-Many avec Loan
     */
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
            ->whereNull('return_date')
            ->orWhere('return_date', '>=', Carbon::now())
            ->exists();
    }

    /**
     * Vérifie si le livre peut être supprimé
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
