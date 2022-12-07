<?php

namespace App\Http\Controllers\Admin;

use App\Auction;
use App\AuctionParticipant;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Interest;
use App\User;
use App\Property;
use App\Attribute;
use App\BookList;
use App\Through;
use App\IncludeList;
use App\ResidentialType;
use App\Country;
use App\City;
use App\Reason;
use App\Coupon;
use App\Offer;
use App\PropertyList;
use App\Reservation;
use App\PropertyRate;
use App\Review;
use App\Ride;
use App\Transformers\Admin\ReservationTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use JavaScript;
class DashboardController extends BaseController
{
    function __construct(ReservationTransformer $reservation_transformer)
    {
        $this->reservation_transformer = $reservation_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_reservation');
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $results = array();

        $allUsers = User::count();
        $users = User::whereUserType('1')->count();
        $rides = User::whereUserType('2')->count();
        $allProperties = Property::where('type', '!=', '10')->count();
        $hotels = Property::whereType('1')->count();
        $furnished = Property::whereType('2')->count();
        $shared_room = Property::whereType('3')->count();
        $restaurant = Property::whereType('4')->count();
        $widding = Property::whereType('5')->count();
        $travel = Property::whereType('6')->count();
        $business = Property::whereType('7')->count();
        $car = Ride::count();
        $residential = Property::whereType('8')->count();
        $attributes = Attribute::count();
        $book_list = BookList::count();
        $through = Through::count();
        $include = IncludeList::count();
        $type = ResidentialType::count();
        $country = Country::count();
        $city = City::count();
        $reason = Reason::count();
        $coupon = Coupon::count();
        $property = PropertyList::count();
        $totalReservation = Offer::count();
        $pending =Offer::where('status', '=', '1')->count();
        $accept =Offer::where('status', '=', '2')->count();
        $reject =Offer::where('status', '=', '3')->count();
        $cancel =Offer::where('status', '=', '4')->count();
        $carReservation = Reservation::whereType('8')->count();
        $hotelReservation = Reservation::whereType('1')->count();
        $furnishedReservation = Reservation::whereType('2')->count();
        $sharedRoomReservation = Reservation::whereType('3')->count();
        $restaurantReservation = Reservation::whereType('4')->count();
        $weddingReservation = Reservation::whereType('5')->count();
        $travelReservation = Reservation::whereType('6')->count();
        $businessReservation = Reservation::whereType('7')->count();
        $residentialReservation = Reservation::whereType('8')->count();
        $total_rate = PropertyRate::count();
        $total_review = Review::count();


        $propertyLineChart = Property::where('type', '!=', '10')
            ->select(DB::raw('count(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') date"))
            ->groupBy('date')
            ->orderBy('date')
            ->take(12)
            ->latest()
            ->pluck('count');

        $reservationLineChart = Reservation::where('type', '!=', '9')
            ->select(DB::raw('count(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') date"))
            ->groupBy('date')
            ->orderBy('date')
            ->take(12)
            ->latest()
            ->pluck('count');

            // dd($propertyLineChart);
        $results['allUsers'] = $allUsers;
        $results['users'] = $users;
        $results['rides'] = $rides;
        $results['allProperties'] = $allProperties;
        $results['hotels'] = $hotels;
        $results['furnished'] = $furnished;
        $results['shared_room'] = $shared_room;
        $results['restaurant'] = $restaurant;
        $results['widding'] = $widding;
        $results['travel'] = $travel;
        $results['business'] = $business;
        $results['car'] = $car;
        $results['residential'] = $residential;
        $results['attributes'] = $attributes;
        $results['book_list'] = $book_list;
        $results['through'] = $through;
        $results['include'] = $include;
        $results['type'] = $type;
        $results['country'] = $country;
        $results['city'] = $city;
        $results['reason'] = $reason;
        $results['coupon'] = $coupon;
        $results['property'] = $property;
        $results['totalReservation'] = $totalReservation;
        $results['pending'] = $pending;
        $results['accept'] = $accept;
        $results['reject'] = $reject;
        $results['cancel'] = $cancel;
        $results['carReservation'] = $carReservation;
        $results['hotelReservation'] = $hotelReservation;
        $results['furnishedReservation'] = $furnishedReservation;
        $results['sharedRoomReservation'] = $sharedRoomReservation;
        $results['restaurantReservation'] = $restaurantReservation;
        $results['weddingReservation'] = $weddingReservation;
        $results['travelReservation'] = $travelReservation;
        $results['businessReservation'] = $businessReservation;
        $results['residentialReservation'] = $residentialReservation;
        $results['total_rate'] = $total_rate;
        $results['total_review'] = $total_review;
        $results['propertyLineChart'] = $propertyLineChart;
        $results['reservationLineChart'] = $reservationLineChart;

        $reservationsData = Reservation::orderBy('id', 'desc')->paginate(6);

        $allReservations = $this->reservation_transformer->transformCollection($reservationsData->getCollection());

        $results['allReservations'] = $allReservations;
        $results['reservationsData'] = $reservationsData;

        //for charts
        $usersCount = User::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupby('year','month')

        ->pluck('data')->toArray();

        // $usersCountLast6Month = User::whereUserType('1')->where("created_at",">", Carbon::now()->subMonths(6))
        //         ->select(DB::raw("monthname(created_at) month"),DB::raw("count('month') as vistors_count"))
        //         ->orderBy('created_at','DESC')
        //         ->groupby('month')
        //         ->limit(6)->pluck('vistors_count')->reverse()->toArray();

        $currentMonth =Carbon::now()->month;
        $usersCountLast6Month=array();
        $usersMonthNameLast6Month=array();
        $ridesCountLast6Month=array();

        for($i = 0 ; $i<6 ; $i++){
            $currentMonth -- ;

            $counter = User::whereUserType('1')->whereYear("created_at","=", Carbon::now()->year)->whereMonth('created_at',$currentMonth)
                ->select(DB::raw("monthname(created_at) month"),DB::raw("count('month') as vistors_count"))
                ->orderBy('created_at','DESC')
                ->groupby('month')
                ->pluck('vistors_count')->first();
                $counter !=null ? array_push($usersCountLast6Month,$counter):array_push($usersCountLast6Month,1);


                $counter = User::whereUserType('2')->whereYear("created_at","=", Carbon::now()->year)->whereMonth('created_at',$currentMonth)
                ->select(DB::raw("monthname(created_at) month"),DB::raw("count('month') as vistors_count"))
                ->orderBy('created_at','DESC')
                ->groupby('month')
                ->pluck('vistors_count')->first();
                $counter !=null ? array_push($ridesCountLast6Month,$counter):array_push($ridesCountLast6Month,1);

                array_push($usersMonthNameLast6Month,date("F", mktime(0, 0, 0, $currentMonth, 1)));
        }
        $usersMonthNameLast6Month=array_reverse($usersMonthNameLast6Month);
        $usersCountLast6Month=array_reverse($usersCountLast6Month);
        $ridesCountLast6Month=array_reverse($ridesCountLast6Month);

        //reservations last 7 days
        $currentDay =Carbon::now()->day;
        $reservationsLast7Days=array();
        $chartColors=array();
        $reservationsLast7DaysCounter=0;
        for($i = 0 ; $i<6 ; $i++){
            $currentDay -- ;

            // dd($currentDay);
            $counter = Offer::whereYear("created_at","=", Carbon::now()->year)
            ->whereMonth('created_at',Carbon::now()->month)
            ->whereDay('created_at',$currentDay)
            ->count();
            $counter !=null ? array_push($reservationsLast7Days,$counter):array_push($reservationsLast7Days,0);
            array_push($chartColors,'#e7eef7');
            // array_push($usersMonthNameLast6Month,date("F", mktime(0, 0, 0, $currentMonth, 1)));
        }
        $reservationsLast7Days=array_reverse($reservationsLast7Days);
        $chartColors=array_reverse($chartColors);

        //change max chart color to primary
        foreach(array_keys($reservationsLast7Days, max($reservationsLast7Days)) as $max){
            $chartColors[$max]='#7367F0';
        }
        // dd($chartColors);
        $reservationsLast7DaysCounter = Reservation::where('type', '!=', '9')
            ->whereYear("created_at","=", Carbon::now()->year)
            ->whereMonth('created_at',Carbon::now()->month)
            ->where('created_at','>',Carbon::now()->subDays(7));

        $results['reservationsLast7DaysCounter'] = $reservationsLast7DaysCounter;


        // dd($usersCountLast6Month);


        //    $usersMonthNameLast6Month = $usersMonthNameLast6Month->reverse()->toArray();
            //    dd($usersMonthNameLast6Month);
        // dd(date("F", mktime(0, 0, 0, $all_users->month, 1)));


        $reservations=Offer::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupby('year','month')
        ->pluck('data')->toArray();


        $hotelsChart = Property::whereType('1')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        ->groupby('year','Day')
        ->pluck('data')->toArray();
        $furnishedChart = Property::whereType('2')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        ->groupby('year','Day')
        ->pluck('data')->toArray();
        $shared_roomChart = Property::whereType('3')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        ->groupby('year','Day')
        ->pluck('data')->toArray();
        $restaurantChart = Property::whereType('4')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        ->groupby('year','Day')
        ->pluck('data')->toArray();
        $widdingChart = Property::whereType('5')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        ->groupby('year','Day')
        ->pluck('data')->toArray();
        $travelChart = Property::whereType('6')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        ->groupby('year','Day')
        ->pluck('data')->toArray();
        $businessChart = Property::whereType('7')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        ->groupby('year','Day')
        ->pluck('data')->toArray();
        $residentialChart = Property::whereType('8')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        ->groupby('year','Day')
        ->pluck('data')->toArray();

        // dd($hotelsChart);
        JavaScript::put([
            'usersCount' => $usersCount,
            'reservations'=> $reservations,
            'totalReservations'=> $totalReservation,
            'accept'=> $accept,
            'pending'=> $pending,
            'reject'=> $reject,
            'cancel'=> $cancel,
            'usersCountLast6Month'=>$usersCountLast6Month,
            'usersMonthNameLast6Month'=>$usersMonthNameLast6Month,
            'ridesCountLast6Month'=>$ridesCountLast6Month,
            'reservationsLast7Days'=>$reservationsLast7Days,
            'chartColors'=>$chartColors,

            //home charts statistics
            'hotelsChart'=>$hotelsChart,
            'furnishedChart'=>$furnishedChart,
            'residentialChart'=>$residentialChart,
            'businessChart'=>$businessChart,
            'shared_roomChart'=>$shared_roomChart,
            'widdingChart'=>$widdingChart,
            'restaurantChart'=>$restaurantChart,
            'travelChart'=>$travelChart
        ]);

        // return view('admin.dashboard.index', compact('results'));
        return view('admin.dashboard.index_2', compact('results'));
    }

    public function detailsChart($type)
    {
        // dd($type);
        $results = array();

        $allUsers = User::count();
        $users = User::whereUserType('1')->count();
        $rides = User::whereUserType('2')->count();
        $allProperties = Property::where('type', '!=', '10')->count();
        $hotels = Property::whereType('1')->count();
        $furnished = Property::whereType('2')->count();
        $shared_room = Property::whereType('3')->count();
        $restaurant = Property::whereType('4')->count();
        $widding = Property::whereType('5')->count();
        $travel = Property::whereType('6')->count();
        $business = Property::whereType('7')->count();
        $car = Ride::count();
        $residential = Property::whereType('8')->count();
        $attributes = Attribute::count();
        $book_list = BookList::count();
        $through = Through::count();
        $include = IncludeList::count();
        // $type = ResidentialType::count();
        $country = Country::count();
        $city = City::count();
        $reason = Reason::count();
        $coupon = Coupon::count();
        $property = PropertyList::count();
        $totalReservation = Reservation::where('type', '=', $type)->count();
        $pending =Reservation::where('type', '=', $type)->where('status', '=', '1')->count();
        $accept =Reservation::where('type', '=', $type)->where('status', '=', '2')->count();
        $reject =Reservation::where('type', '=', $type)->where('status', '=', '3')->count();
        $cancel =Reservation::where('type', '=', $type)->where('status', '=', '4')->count();
        // dd($pending.$type);
        $carReservation = Reservation::whereType('8')->count();
        $hotelReservation = Reservation::whereType('1')->count();
        $furnishedReservation = Reservation::whereType('2')->count();
        $sharedRoomReservation = Reservation::whereType('3')->count();
        $restaurantReservation = Reservation::whereType('4')->count();
        $weddingReservation = Reservation::whereType('5')->count();
        $travelReservation = Reservation::whereType('6')->count();
        $businessReservation = Reservation::whereType('7')->count();
        $residentialReservation = Reservation::whereType('8')->count();
        $total_rate = PropertyRate::count();
        $total_review = Review::count();


        $propertyLineChart = Property::where('type', '!=', '10')
            ->select(DB::raw('count(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') date"))
            ->groupBy('date')
            ->orderBy('date')
            ->take(12)
            ->latest()
            ->pluck('count');

        $reservationLineChart = Reservation::where('type', '=', $type)
            ->select(DB::raw('count(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') date"))
            ->groupBy('date')
            ->orderBy('date')
            ->take(12)
            ->latest()
            ->pluck('count');

            // dd($propertyLineChart);
        $results['allUsers'] = $allUsers;
        $results['users'] = $users;
        $results['rides'] = $rides;
        $results['allProperties'] = $allProperties;
        $results['hotels'] = $hotels;
        $results['furnished'] = $furnished;
        $results['shared_room'] = $shared_room;
        $results['restaurant'] = $restaurant;
        $results['widding'] = $widding;
        $results['travel'] = $travel;
        $results['business'] = $business;
        $results['car'] = $car;
        $results['residential'] = $residential;
        $results['attributes'] = $attributes;
        $results['book_list'] = $book_list;
        $results['through'] = $through;
        $results['include'] = $include;
        $results['type'] = $type;
        $results['country'] = $country;
        $results['city'] = $city;
        $results['reason'] = $reason;
        $results['coupon'] = $coupon;
        $results['property'] = $property;
        $results['totalReservation'] = $totalReservation;
        $results['pending'] = $pending;
        $results['accept'] = $accept;
        $results['reject'] = $reject;
        $results['cancel'] = $cancel;
        $results['carReservation'] = $carReservation;
        $results['hotelReservation'] = $hotelReservation;
        $results['furnishedReservation'] = $furnishedReservation;
        $results['sharedRoomReservation'] = $sharedRoomReservation;
        $results['restaurantReservation'] = $restaurantReservation;
        $results['weddingReservation'] = $weddingReservation;
        $results['travelReservation'] = $travelReservation;
        $results['businessReservation'] = $businessReservation;
        $results['residentialReservation'] = $residentialReservation;
        $results['total_rate'] = $total_rate;
        $results['total_review'] = $total_review;
        $results['propertyLineChart'] = $propertyLineChart;
        $results['reservationLineChart'] = $reservationLineChart;

        $reservationsData = Reservation::orderBy('id', 'desc')->where('type', '=', $type)->paginate(6);

        $allReservations = $this->reservation_transformer->transformCollection($reservationsData->getCollection());

        $results['allReservations'] = $allReservations;
        $results['reservationsData'] = $reservationsData;

        //for charts
        $usersCount = User::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupby('year','month')

        ->pluck('data')->toArray();

        // $usersCountLast6Month = User::whereUserType('1')->where("created_at",">", Carbon::now()->subMonths(6))
        //         ->select(DB::raw("monthname(created_at) month"),DB::raw("count('month') as vistors_count"))
        //         ->orderBy('created_at','DESC')
        //         ->groupby('month')
        //         ->limit(6)->pluck('vistors_count')->reverse()->toArray();

        $currentMonth =Carbon::now()->month;
        $usersCountLast6Month=array();
        $usersMonthNameLast6Month=array();
        $ridesCountLast6Month=array();

        for($i = 0 ; $i<6 ; $i++){
            $currentMonth -- ;

            $counter = User::whereUserType('1')->whereYear("created_at","=", Carbon::now()->year)->whereMonth('created_at',$currentMonth)
                ->select(DB::raw("monthname(created_at) month"),DB::raw("count('month') as vistors_count"))
                ->orderBy('created_at','DESC')
                ->groupby('month')
                ->pluck('vistors_count')->first();
                $counter !=null ? array_push($usersCountLast6Month,$counter):array_push($usersCountLast6Month,1);


                $counter = User::whereUserType('2')->whereYear("created_at","=", Carbon::now()->year)->whereMonth('created_at',$currentMonth)
                ->select(DB::raw("monthname(created_at) month"),DB::raw("count('month') as vistors_count"))
                ->orderBy('created_at','DESC')
                ->groupby('month')
                ->pluck('vistors_count')->first();
                $counter !=null ? array_push($ridesCountLast6Month,$counter):array_push($ridesCountLast6Month,1);

                array_push($usersMonthNameLast6Month,date("F", mktime(0, 0, 0, $currentMonth, 1)));
        }
        $usersMonthNameLast6Month=array_reverse($usersMonthNameLast6Month);
        $usersCountLast6Month=array_reverse($usersCountLast6Month);
        $ridesCountLast6Month=array_reverse($ridesCountLast6Month);

        //reservations last 7 days
        $currentDay =Carbon::now()->day;
        $reservationsLast7Days=array();
        $chartColors=array();
        $reservationsLast7DaysCounter=0;
        for($i = 0 ; $i<6 ; $i++){
            $currentDay -- ;

            // dd($currentDay);
            $counter = Reservation::where('type', '=', $type)
            ->whereYear("created_at","=", Carbon::now()->year)
            ->whereMonth('created_at',Carbon::now()->month)
            ->whereDay('created_at',$currentDay)
            ->count();
            $counter !=null ? array_push($reservationsLast7Days,$counter):array_push($reservationsLast7Days,0);
            array_push($chartColors,'#e7eef7');
            // array_push($usersMonthNameLast6Month,date("F", mktime(0, 0, 0, $currentMonth, 1)));
        }
        $reservationsLast7Days=array_reverse($reservationsLast7Days);
        $chartColors=array_reverse($chartColors);

        //change max chart color to primary
        foreach(array_keys($reservationsLast7Days, max($reservationsLast7Days)) as $max){
            $chartColors[$max]='#7367F0';
        }
        // dd($chartColors);
        $reservationsLast7DaysCounter = Reservation::where('type', '=', $type)
            ->whereYear("created_at","=", Carbon::now()->year)
            ->whereMonth('created_at',Carbon::now()->month)
            ->where('created_at','>',Carbon::now()->subDays(7));

        $results['reservationsLast7DaysCounter'] = $reservationsLast7DaysCounter;


        // dd($usersCountLast6Month);


        //    $usersMonthNameLast6Month = $usersMonthNameLast6Month->reverse()->toArray();
            //    dd($usersMonthNameLast6Month);
        // dd(date("F", mktime(0, 0, 0, $all_users->month, 1)));


        $reservations=Reservation::where('type', '=', $type)->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupby('year','month')
        ->pluck('data')->toArray();

        //reservations arrays
        $pendingArray =Reservation::where('type', '=', $type)->where('status', '=', '1')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupby('year','month')
        ->pluck('data')->toArray();
        $acceptArray =Reservation::where('type', '=', $type)->where('status', '=', '2')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupby('year','month')
        ->pluck('data')->toArray();
        $rejectArray =Reservation::where('type', '=', $type)->where('status', '=', '3')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupby('year','month')
        ->pluck('data')->toArray();
        $cancelArray=Reservation::where('type', '=', $type)->where('status', '=', '4')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->groupby('year','month')
        ->pluck('data')->toArray();

        // dd($pendingArray);


        // $hotelsChart = Property::whereType('1')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        // ->groupby('year','Day')
        // ->pluck('data')->toArray();
        // $furnishedChart = Property::whereType('2')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        // ->groupby('year','Day')
        // ->pluck('data')->toArray();
        // $shared_roomChart = Property::whereType('3')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        // ->groupby('year','Day')
        // ->pluck('data')->toArray();
        // $restaurantChart = Property::whereType('4')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        // ->groupby('year','Day')
        // ->pluck('data')->toArray();
        // $widdingChart = Property::whereType('5')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        // ->groupby('year','Day')
        // ->pluck('data')->toArray();
        // $travelChart = Property::whereType('6')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        // ->groupby('year','Day')
        // ->pluck('data')->toArray();
        // $businessChart = Property::whereType('7')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        // ->groupby('year','Day')
        // ->pluck('data')->toArray();
        // $residentialChart = Property::whereType('9')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, Day(created_at) Day'))
        // ->groupby('year','Day')
        // ->pluck('data')->toArray();


        // dd($hotelsChart);
        JavaScript::put([
            'usersCount' => $usersCount,
            'reservations'=> $reservations,
            'totalReservations'=> $totalReservation,

            'acceptArray'=> $acceptArray,
            'pendingArray'=> $pendingArray,
            'rejectArray'=> $rejectArray,
            'cancelArray'=> $cancelArray,

            'accept'=> $accept,
            'pending'=> $pending,
            'reject'=> $reject,
            'cancel'=> $cancel,
            'usersCountLast6Month'=>$usersCountLast6Month,
            'usersMonthNameLast6Month'=>$usersMonthNameLast6Month,
            'ridesCountLast6Month'=>$ridesCountLast6Month,
            'reservationsLast7Days'=>$reservationsLast7Days,
            'chartColors'=>$chartColors,

            //home charts statistics
            // 'hotelsChart'=>$hotelsChart,
            // 'furnishedChart'=>$furnishedChart,
            // 'residentialChart'=>$residentialChart,
            // 'businessChart'=>$businessChart,
            // 'shared_roomChart'=>$shared_roomChart,
            // 'widdingChart'=>$widdingChart,
            // 'restaurantChart'=>$restaurantChart,
            // 'travelChart'=>$travelChart
        ]);

        // return view('admin.dashboard.index', compact('results'));
        return view('admin.dashboard.details', compact('results'));
    }

    public function index_v2(Request $request)
    {
        $results = array();

        $allUsers = User::count();
        $users = User::whereUserType('1')->count();
        $rides = User::whereUserType('2')->count();
        $allProperties = Property::where('type', '!=', '10')->count();
        $hotels = Property::whereType('1')->count();
        $furnished = Property::whereType('2')->count();
        $shared_room = Property::whereType('3')->count();
        $restaurant = Property::whereType('4')->count();
        $widding = Property::whereType('5')->count();
        $travel = Property::whereType('6')->count();
        $business = Property::whereType('7')->count();
        $car = Ride::count();
        $residential = Property::whereType('8')->count();
        $attributes = Attribute::count();
        $book_list = BookList::count();
        $through = Through::count();
        $include = IncludeList::count();
        $type = ResidentialType::count();
        $country = Country::count();
        $city = City::count();
        $reason = Reason::count();
        $coupon = Coupon::count();
        $property = PropertyList::count();
        $totalReservation = Offer::count();
        $carReservation = Reservation::whereType('8')->count();
        $hotelReservation = Reservation::whereType('1')->count();
        $furnishedReservation = Reservation::whereType('2')->count();
        $sharedRoomReservation = Reservation::whereType('3')->count();
        $restaurantReservation = Reservation::whereType('4')->count();
        $weddingReservation = Reservation::whereType('5')->count();
        $travelReservation = Reservation::whereType('6')->count();
        $businessReservation = Reservation::whereType('7')->count();
        $residentialReservation = Reservation::whereType('8')->count();
        $total_rate = PropertyRate::count();
        $total_review = Review::count();

        $propertyLineChart = Property::where('type', '!=', '10')
            ->select(DB::raw('count(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') date"))
            ->groupBy('date')
            ->orderBy('date')
            ->take(12)
            ->latest()
            ->pluck('count');

        $reservationLineChart = Reservation::where('type', '!=', '9')
            ->select(DB::raw('count(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') date"))
            ->groupBy('date')
            ->orderBy('date')
            ->take(12)
            ->latest()
            ->pluck('count');

        $results['allUsers'] = $allUsers;
        $results['users'] = $users;
        $results['rides'] = $rides;
        $results['allProperties'] = $allProperties;
        $results['hotels'] = $hotels;
        $results['furnished'] = $furnished;
        $results['shared_room'] = $shared_room;
        $results['restaurant'] = $restaurant;
        $results['widding'] = $widding;
        $results['travel'] = $travel;
        $results['business'] = $business;
        $results['car'] = $car;
        $results['residential'] = $residential;
        $results['attributes'] = $attributes;
        $results['book_list'] = $book_list;
        $results['through'] = $through;
        $results['include'] = $include;
        $results['type'] = $type;
        $results['country'] = $country;
        $results['city'] = $city;
        $results['reason'] = $reason;
        $results['coupon'] = $coupon;
        $results['property'] = $property;
        $results['totalReservation'] = $totalReservation;
        $results['carReservation'] = $carReservation;
        $results['hotelReservation'] = $hotelReservation;
        $results['furnishedReservation'] = $furnishedReservation;
        $results['sharedRoomReservation'] = $sharedRoomReservation;
        $results['restaurantReservation'] = $restaurantReservation;
        $results['weddingReservation'] = $weddingReservation;
        $results['travelReservation'] = $travelReservation;
        $results['businessReservation'] = $businessReservation;
        $results['residentialReservation'] = $residentialReservation;
        $results['total_rate'] = $total_rate;
        $results['total_review'] = $total_review;
        $results['propertyLineChart'] = $propertyLineChart;
        $results['reservationLineChart'] = $reservationLineChart;

        // return view('admin.dashboard.index', compact('results'));
        return view('admin.dashboard.index_2_v2', compact('results'));
    }
}
