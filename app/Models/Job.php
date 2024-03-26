<?php

namespace App\Models;

use App\Models\Scopes\AuthScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory , SoftDeletes;
    protected static function booted()
    {
        static::addGlobalScope(new AuthScope);
    }
    protected $fillable = [
        'user_id',
        'title',
        'category_id',
        'job_type_id',
        'vacancy',
        'salary',
        'location',
        'description',
        'benefits',
        'responsibility',
        'qualifications',
        'keywords',
        'is_featured',
        'status',
        'experience',
        'company_name',
        'company_location',
        'company_website',
        'updated_at',
        'deleted_at'
    ];


    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
