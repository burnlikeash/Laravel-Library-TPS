<?php
// app/Models/Borrower.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone'
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