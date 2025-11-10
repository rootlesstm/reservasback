<?php
namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // GET /api/rooms
    public function index()
    {
        return response()->json(Room::all());
    }

    public function update(Request $request, $id)
    {
        return response()->json(['mensaje' => "Sala $id actualizada", 'data' => $request->all()]);
    }

    // POST /api/rooms (opcional, solo si quieres crear salas vía API)
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|unique:rooms,name',
            'capacity' => 'required|integer|min:1',
        ]);

        $room = Room::create($request->all());

        return response()->json($room, 201);
    }

    public function destroy($id)
    {
        return response()->json(['mensaje' => "Sala $id eliminada"]);
    }
}
