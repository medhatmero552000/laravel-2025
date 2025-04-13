<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Classroom extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['classroom'];
    protected $fillable = [];


    # -------------------- THE TABLE ASSOCIATED WITH THE MODEL ------------------- #
    protected $table = 'classrooms';

    # ----------------- THE ATTRIBUTES THAT ARE MASS ASSIGNNABLE ----------------- #
    protected $guarded = ['id'];


    # -------------------------------- UPLOAD PATH ------------------------------- #
    const UPLOADPATH = 'images/';

    # ------------------------------- UPLOAD FIELDS ------------------------------ #
    const UPLOADFIELDS = [];



    public function classroom_grade()
    {
        return $this->belongsTo(Grade::class);
    }
}


##----------------------------------------RELATIONSHIPS

##----------------------------------------ATTRIBUTES

##----------------------------------------CUSTOM FUNCTIONS

##----------------------------------------SCOPS

##----------------------------------------ACCESSORS AND MUTATORS
