<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SystemSetting extends Model
{
    use HasFactory;

    protected $primaryKey = null;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'currency_id',
        'timezone_id',
        'clock_format',
        'date_format',
        'datetime_format'
    ];

    public function currency()
    {
        return $this->belongsTo(Currencies::class);
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }
}
