<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomTranslation extends Model
{
    use HasFactory;
    // use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['classroom'];

# -------------------- THE TABLE ASSOCIATED WITH THE MODEL ------------------- #
    protected $table = 'classroom_translations'; 

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