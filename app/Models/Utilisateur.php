<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Utilisateur extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'user_id', 'nom', 'prenom', 'numeroDeTelephone', 'photoProfil'
    ];


    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'conducteur_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'passager_id');
    }

    public function messageries()
    {
        return $this->hasMany(Messagerie::class, 'utilisateur1_id');
    }

    public function isConducteur()
    {
        return $this->hasMany(Trajet::class, 'conducteur_id');
    }

    public function isPassager()
    {
        return $this->hasMany(Reservation::class, 'passager_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
