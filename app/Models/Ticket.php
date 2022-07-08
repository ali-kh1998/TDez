<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['name','status','booking_id','show_id','seat_id'];

    public function Booking()
	{
		return $this->belongsTo('App\Models\Booking');
	}

    public function Show()
	{
		return $this->belongsTo('App\Models\Show');
	}

    public function Seat()
	{
		return $this->belongsTo('App\Models\Seat');
	}

}