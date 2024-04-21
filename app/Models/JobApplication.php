<?php

namespace App\Models;
use App\Models\Scopes\AuthScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class JobApplication extends Model
{
    use HasFactory , SoftDeletes;
    protected static function booted()
    {
        static::addGlobalScope(new AuthScope);

    }
    protected $guarded = [];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
