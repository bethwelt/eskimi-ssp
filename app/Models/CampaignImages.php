<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignImages extends Model
{
    use HasFactory;

      protected $fillable = [
        'campaigns_id',
        'campaign_image_path',
        'campaign_image_caption',
    ];

    public function image()
    {
        return $this->belongsTo(Campaigns::class);
    }
}
