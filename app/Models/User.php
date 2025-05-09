<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     // Relationship to Role
     public function role()
     {
         return $this->belongsTo(Role::class);
     }
 
     // Relationship to Customers added by this user
     public function addedCustomers()
     {
         return $this->hasMany(Customer::class, 'added_by');
     }
 
     // Relationship to Invoices issued by this user
     public function issuedInvoices()
     {
         return $this->hasMany(Invoice::class, 'issued_by');
     }
 
     // Relationship to Expenses
     public function expenses()
     {
         return $this->hasMany(Expense::class, 'added_by');
     }
 
     // Relationship to Employee profile
     public function employee()
     {
         return $this->hasOne(Employee::class, 'user_id');
     }
}
