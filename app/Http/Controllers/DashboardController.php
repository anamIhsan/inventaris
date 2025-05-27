<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\ExitItem;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $items = Item::count();
        $suppliers = Supplier::count();
        $borrowings = Borrowing::count();
        $exitItems = ExitItem::count();

        return view('admin.pages.dashboard', compact('items', 'suppliers', 'borrowings', 'exitItems'));
    }
}
