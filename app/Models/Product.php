<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
     use HasFactory, Notifiable;
        protected $guarded = [];

public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id','id');
    }
     public function city(){
        return $this->belongsTo(City::class, 'city_id','id');
    }
}
