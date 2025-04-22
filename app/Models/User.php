<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

     protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'usertype',
        'phone',
        'address',
        'image',
        'nama_lengkap',
    ];

    public function isAdmin()
    {
        return $this->usertype === 'admin';
    }

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

    protected static function boot() {
        parent::boot();
        
        static::creating(function ($user) {
            $user->id = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT); 
        });
    }

    public function carts(): HasMany {
        return $this->hasMany(Cart::class);
    }

    public function checkouts(): HasMany {
        return $this->hasMany(Checkout::class);
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }

    public function notifications(): HasMany {
        return $this->hasMany(Notification::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function transactions()
    {
        return $this->hasMany(Kasir::class);
    }

    public function hasBookings()
    {
        return $this->bookings()->exists();
    }

    public function mostUsedServices()
    {
        $popularServices = collect();

        // Get all successful transactions
        $kasirs = Kasir::where('status_transaksi', 'success')->get();

        // Create a frequency counter for each service
        $serviceCounter = [];

        // Loop through each transaction
        foreach ($kasirs as $kasir) {
            // Get layanan IDs from the JSON column
            $layananIds = json_decode($kasir->layanan_id);
            
            // Count each service occurrence
            foreach ($layananIds as $layananId) {
                $layanan = Layanan::find($layananId);
                if ($layanan) {
                    $serviceName = $layanan->nama_layanan;
                    if (!isset($serviceCounter[$serviceName])) {
                        $serviceCounter[$serviceName] = 0;
                    }
                    $serviceCounter[$serviceName]++;
                }
            }
        }

        // Sort by count (popularity)
        arsort($serviceCounter);

        // Take top 5 and convert to collection format
        $counter = 0;
        foreach ($serviceCounter as $name => $count) {
            if ($counter < 5) {
                $popularServices->push((object)[
                    'nama_layanan' => $name,
                    'count' => $count
                ]);
                $counter++;
            } else {
                break;
            }
        }
    }
}