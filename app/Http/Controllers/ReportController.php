<?php

namespace App\Http\Controllers;

use App\Models\ExitItem;
use App\Models\IncomingItem;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.pages.report.index');
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'date|nullable',
            'type'       => 'required|in:incoming_item,exit_item,stok_item',
        ]);

        $start = $request->start_date;
        $end = $request->end_date;
        $type = $request->type;

        if ($type === 'incoming_item') {
            $data = IncomingItem::with(['items', 'suppliers'])
                ->whereBetween('entry_date', [$start, $end])
                ->get();
        } elseif ($type === 'exit_item') {
            $data = ExitItem::with('items')
                ->whereBetween('date_out', [$start, $end])
                ->get();
        } else {
            $data = Item::with(['incomingItems', 'exitItems', 'borrowings'])->get();

            $data->transform(function ($item) {
                $item->stok = $item->incomingItems->sum('quantity')
                            - $item->exitItems->sum('quantity')
                            - $item->borrowings->where('status', 'dipinjam')->sum('quantity');

                // Tambahkan warning jika stok di bawah batas
                $item->stok_warning = $item->stok <= $item->minimum_stock;
                return $item;
            });
        }

        return view('admin.pages.report.index', compact('data', 'start', 'end', 'type'));
    }

    public function exportPdf(Request $request)
{
    $type = $request->type;
    $start = $request->start;
    $end = $request->end;

    // Ambil dan decode data yang dikirim dari input hidden
    $rawData = json_decode($request->input('data'), true);
    $data = [];

    if ($type === 'incoming_item') {
        foreach ($rawData as $item) {
            $item['items'] = \App\Models\Item::find($item['item_id']);
            $item['suppliers'] = \App\Models\Supplier::find($item['supplier_id']);
            $data[] = $item;
        }
    } elseif ($type === 'exit_item') {
        foreach ($rawData as $item) {
            $item['items'] = \App\Models\Item::find($item['item_id']);
            $data[] = $item;
        }
    } elseif ($type === 'stok_item') {
        $data = $rawData;
    }

    // Kirim ke view untuk dirender ke PDF
    $view = View::make('admin.pages.report.pdf', [
        'data' => $data,
        'start' => $start,
        'end' => $end,
        'type' => $type
    ]);

    $pdf = Pdf::loadHtml($view->render())->setPaper('a4', 'landscape');
    return $pdf->stream("laporan-{$type}.pdf");
}

}
