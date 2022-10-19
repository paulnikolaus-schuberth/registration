<?php

namespace App\Http\Controllers;

use App\Http\Livewire\EventRegistration;
use App\Models\Event;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show(Request $request, Event $event): View|Factory
    {
        $user = Auth::user();

        if ($user == null) {
            abort(401);
        }
        $hasRegistered = $user->hasRegisteredFor($event);

        $part = EventRegistration::PART_ONE;
        if ($request->filled('part')) {
            $string = $request->query('part');
            if (is_array($string)) {
                $string = $string[0];
            }
            $input = strtolower($string);

            if (in_array($input, EventRegistration::KNOWN_PARTS)) {
                $part = $input;
            }
        }

        return view('event.registration')->with([
            'event' => $event,
            'hasRegistered' => $hasRegistered,
            'part' => $part,
        ]);
    }
}
