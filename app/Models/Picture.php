<?php

namespace App\Models;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Picture extends Model
{
    use HasFactory;


protected $fillable= [
    'title','description','image','user_id'
];

//cette fonction recupere les information de cle etrangere et l'affiche
protected $with=[
    'user'
];
    /**
     * Get the user that owns the picture
     *
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}


