<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['ar_title', 'en_title', 'slug', 'ar_content', 'en_content', 'image'];

    // Function to return title based on language
    public function getTitleAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->ar_title : $this->en_title;
    }

    // Function to return content based on language
    public function getContentAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->ar_content : $this->en_content;
    }
}
