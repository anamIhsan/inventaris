<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\ExitItem;
use App\Models\IncomingItem;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $items = Item::count();
        $suppliers = Supplier::count();
        $borrowings = Borrowing::count();
        $users = User::count();
        $exitItems = ExitItem::with('items')
            ->where('date_out', '>=', Carbon::now()->subDays(30))
            ->latest()
            ->get();
        $incomingItems = IncomingItem::with('items')
            ->where('entry_date', '>=', Carbon::now()->subDays(30))
            ->latest()
            ->get();

        return view('admin.pages.dashboard', compact('items', 'suppliers', 'borrowings', 'users', 'exitItems', 'incomingItems'));
    }
}
