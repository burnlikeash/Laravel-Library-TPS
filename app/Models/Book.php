<?php
// app/Models/Book.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author', 'isbn', 'quantity', 'available_quantity'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function activeBorrows()
    {
        return $this->hasMany(Transaction::class)->where('status', 'borrowed');
    }
}