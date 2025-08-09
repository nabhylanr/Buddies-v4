<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recap extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'nama_perusahaan',
        'cabang',
        'sales',
        'keterangan',
        'status' 
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getFullCompanyNameAttribute()
    {
        return $this->nama_perusahaan . ' - ' . $this->cabang;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsScheduled()
    {
        $this->update(['status' => 'scheduled']);
    }

    public function markAsPending()
    {
        $this->update(['status' => 'pending']);
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
}