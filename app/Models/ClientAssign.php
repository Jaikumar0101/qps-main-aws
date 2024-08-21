<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
    ];

    /**
     * Get the user that owns the client assignment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer that is assigned to the user.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
