<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentDetails extends Model
{
    use HasFactory;

    // テーブル名（規約に沿っていれば不要）
    protected $table = 'treatment_details';

    protected $fillable = [
        'reservation_id',
        'treatment_date',
        'campaign',
        'menu',
        'content',
        'products',
        'employee',
        'desired_style',
        'hair_and_scalp',
        'allergy',
        'customer_feedback',
        'next_proposal',
        'memo',
    ];

    /**
     * リレーション：予約（uuid紐付け）
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'reservation_id');
    }
}
