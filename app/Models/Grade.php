<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Grade extends Model  implements TranslatableContract
{
    use HasFactory;
    // use SoftDeletes;
    use Translatable;

    public $translatedAttributes = ['name', 'notes'];
    protected $fillable = [];


# -------------------- THE TABLE ASSOCIATED WITH THE MODEL ------------------- #
    protected $table = 'Grades'; 

# ----------------- THE ATTRIBUTES THAT ARE MASS ASSIGNNABLE ----------------- #
    protected $guarded = ['id']; 


# -------------------------------- UPLOAD PATH ------------------------------- #
    const UPLOADPATH='images/';
    
# ------------------------------- UPLOAD FIELDS ------------------------------ #
    const UPLOADFIELDS=[];
}


##----------------------------------------RELATIONSHIPS

##----------------------------------------ATTRIBUTES

##----------------------------------------CUSTOM FUNCTIONS

##----------------------------------------SCOPS

##----------------------------------------ACCESSORS AND MUTATORS