<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // GET /api/bookings?room_id=1&date=YYYY-MM-DD
    public function index(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'date'    => 'required|date',
        ]);

        $startOfDay = $request->date . ' 00:00:00';
        $endOfDay   = $request->date . ' 23:59:59';

        $bookings = Booking::where('room_id', $request->room_id)
            ->whereBetween('start_time', [$startOfDay, $endOfDay])
            ->orderBy('start_time')
            ->get();

        return response()->json($bookings);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['mensaje' => "Reservacion $id actualizado", 'data' => $request->all()]);
    }

    // POST /api/bookings
    public function store(Request $request)
    {
        $request->validate([
            // 'room_id'    => 'required|integer|exists:rooms,id',
            'created_at' => 'required|date',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
        ]);

        $user = Auth::user();

        // Validar solapamiento de horarios
        $conflict = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '<', $request->start_time)
                            ->where('end_time', '>', $request->end_time);
                    });
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'error' => 'Conflicto de horario. La sala ya está reservada en ese rango.',
            ], 409);
        }

        $booking = Booking::create([
            'room_id'    => $request->room_id,
            'user_id'    => $request->user_id ?? 1, // temporal si no tienes JWT aún
            'created_at' => $request->created_at,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,

        ]);

        return response()->json($booking, 201);
    }

    public function destroy($id)
    {
        return response()->json(['mensaje' => "Reservacion $id eliminada"]);
    }
}
