<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reservation;
use App\ReservationHistory;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\Validator;
Use Image;
use Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use App\Transformers\Admin\ReservationTransformer;

class ReservationController extends Controller
{
    function __construct(ReservationTransformer $reservation_transformer) 
    {
        $this->reservation_transformer = $reservation_transformer;

        $this->middleware(function ($request, $next) {
            checkPermission('is_reservation');
            return $next($request);
        });
    }

    public function index($type)
    {
        checkGate('can_show');

        $reservations = Reservation::whereType($type)->orderBy('id', 'desc')->paginate(20);

        $reservations = $this->reservation_transformer->transformCollection($reservations->getCollection());

        $data = Reservation::whereType($type)->orderBy('id', 'desc')->paginate(20);

        return view('admin.reservation.index', compact('reservations', 'data'));
    }

    public function show($id)
    {
        checkGate('can_show');

        $reservation = Reservation::findOrFail($id);

        $reservation = $this->reservation_transformer->transform($reservation);

        return view('admin.reservation.show', compact('reservation'));
    }
}
