<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $guarded=[];
    // protected $fillable = [
    // 	'name', 'is_admin', 'is_user', 'is_ride', 'is_hotel', 'is_furnished',
	// 	'is_shared', 'is_restaurant', 'is_wedding', 'is_travel', 'is_business',
	// 	'is_car', 'is_residential', 'is_attributes', 'is_book_list', 'is_through',
	// 	'is_include', 'is_residential_type', 'is_country', 'is_city', 'is_reason',
    //     'is_coupon', 'is_property', 'is_reservation'
	// ];

    protected $dates = ['created_at','updated_at'];

    protected $hidden = ['created_at','updated_at'];

    protected $appends = ['created_at_ar'];

    public function admins()
    {
        return $this->hasMany('App\AdminPermission');
    }

    public function getCreatedAtArAttribute()
    {
        $date = $this->created_at;
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        $your_date = date('y-m-d', strtotime($date)); // The Current Date
        $en_month = date("M", strtotime($your_date));
        foreach ($months as $en => $ar) {
            if ($en == $en_month) { $ar_month = $ar; }
        }

        $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
        $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date('D', strtotime($date)); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);

        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0","1","2","3","4","5","6","7","8","9","am","pm");
        $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩","صباحآ","مساءآ");
        $endTimeText = 'م الساعة ';
        $current_date = ' '.date('d', strtotime($date)).' '.$ar_month.' '.date('Y', strtotime($date));
        $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);

        $endText = 'منذ ';

        return $endText . ' ' .$arabic_date;
        // return $this->created_at;
    }

}
