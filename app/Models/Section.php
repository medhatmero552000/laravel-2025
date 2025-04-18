<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;


# -------------------- THE TABLE ASSOCIATED WITH THE MODEL ------------------- #
    protected $table = 'sections'; 

# ----------------- THE ATTRIBUTES THAT ARE MASS ASSIGNNABLE ----------------- #
    protected $guarded = ['id']; 


# -------------------------------- UPLOAD PATH ------------------------------- #
    const UPLOADPATH='images/';
    
# ------------------------------- UPLOAD FIELDS ------------------------------ #
    const UPLOADFIELDS=[];
    public function grade()
    {
        return $this->belongsTo(Grade::class ,'grade_id','id'); 
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class,'classroom_id','id'); 
    }
}


##----------------------------------------RELATIONSHIPS

##----------------------------------------ATTRIBUTES

##----------------------------------------CUSTOM FUNCTIONS

##----------------------------------------SCOPS

##----------------------------------------ACCESSORS AND MUTATORS