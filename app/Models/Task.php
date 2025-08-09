<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'recap_id',
        'description',
        'datetime',
        'place',
        'implementor',
        'status',
        'completed_at'
    ];
    
    protected $casts = [
        'datetime' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function recap()
    {
        return $this->belongsTo(Recap::class);
    }

    public function getTitleAttribute()
    {
        return $this->recap ? $this->recap->nama_perusahaan : 'Perusahaan tidak ditemukan';
    }

    public function getFullCompanyNameAttribute()
    {
        return $this->recap ? $this->recap->full_company_name : 'Perusahaan tidak ditemukan';
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getDateKeyAttribute()
    {
        return $this->datetime->setTimezone('Asia/Jakarta')->format('Y-m-d');
    }

    public function getTimeAttribute()
    {
        return $this->datetime->setTimezone('Asia/Jakarta')->format('g:i A');
    }

    public function getIsoDatetimeAttribute()
    {
        return $this->datetime->toISOString();
    }

    public function getTime24Attribute()
    {
        return $this->datetime->setTimezone('Asia/Jakarta')->format('H:i');
    }

    public function getFormattedDateAttribute()
    {
        return $this->datetime->setTimezone('Asia/Jakarta')->format('d M Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->getTime24Attribute();
    }

    public function getFormattedCompletedAtAttribute()
    {
        if (!$this->completed_at) {
            return '-';
        }
        
        return $this->completed_at->setTimezone('Asia/Jakarta')->format('d M Y H:i');
    }

    public function setDatetimeAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['datetime'] = Carbon::createFromFormat('Y-m-d\TH:i', $value, 'Asia/Jakarta')->utc();
        } else {
            $this->attributes['datetime'] = $value;
        }
    }

    public function setCompletedAtAttribute($value)
    {
        if ($value) {
            $this->attributes['completed_at'] = $value;
        } else {
            $this->attributes['completed_at'] = null;
        }
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => Carbon::now() 
        ]);
    }

    public function markAsPending()
    {
        $this->update([
            'status' => 'pending',
            'completed_at' => null
        ]);
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function getCompletedAtRelativeAttribute()
    {
        if (!$this->completed_at) {
            return null;
        }
        
        return $this->completed_at->setTimezone('Asia/Jakarta')->diffForHumans();
    }

    public function isOverdue()
    {
        return $this->status === 'pending' && 
            $this->datetime->lt(Carbon::now('Asia/Jakarta'));
    }

    public function getOverdueDurationAttribute()
    {
        if (!$this->isOverdue()) {
            return null;
        }
        
        $now = Carbon::now('Asia/Jakarta');
        $diff = $this->datetime->diff($now);
        
        if ($diff->days > 0) {
            return $diff->days . ' hari ' . $diff->h . ' jam yang lalu';
        } elseif ($diff->h > 0) {
            return $diff->h . ' jam ' . $diff->i . ' menit yang lalu';
        } else {
            return $diff->i . ' menit yang lalu';
        }
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                    ->where('datetime', '<', Carbon::now('Asia/Jakarta'));
    }

    public function getOverdueStatusAttribute()
    {
        if (!$this->isOverdue()) {
            return 'on_time';
        }
        
        $hoursOverdue = $this->datetime->diffInHours(Carbon::now('Asia/Jakarta'));
        
        if ($hoursOverdue <= 2) {
            return 'recently_overdue';
        } elseif ($hoursOverdue <= 24) {
            return 'overdue';
        } else {
            return 'critically_overdue';
        }
    }
}