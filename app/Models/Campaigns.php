<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    use HasFactory;

      protected $fillable = [
        //'id',
        'user_id', 
        'name',
        'total_budget',
        'daily_budget',
        'name',
        'date_from',
        'date_to'
    ];
  
         
            

    //user has many campaigns

      public function author()
    {
        return $this->belongsTo(User::class);
    }

    //campaign images
       public function campaigns_images()
    {
        return $this->hasMany(CampaignImages::class);
    }

    
}
