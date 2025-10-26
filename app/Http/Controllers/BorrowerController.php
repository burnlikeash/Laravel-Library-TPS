<?php
// app/Http/Controllers/BorrowerController.php
namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    public function index()
    {
        $borrowers = Borrower::withCount('activeBorrows')->get();
        return view('borrowers.index', compact('borrowers'));
    }

    public function create()
    {
        return view('borrowers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:borrowers,email',
            'phone' => 'required|string|max:20',
        ]);

        Borrower::create($request->all());

        return redirect()->route('borrowers.index')->with('success', 'Borrower added successfully!');
    }

    public function show(Borrower $borrower)
    {
        $borrower->load('transactions.book');
        return view('borrowers.show', compact('borrower'));
    }

    public function edit(Borrower $borrower)
    {
        return view('borrowers.edit', compact('borrower'));
    }

    public function update(Request $request, Borrower $borrower)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:borrowers,email,' . $borrower->id,
            'phone' => 'required|string|max:20',
        ]);

        $borrower->update($request->all());

        return redirect()->route('borrowers.index')->with('success', 'Borrower updated successfully!');
    }

    public function destroy(Borrower $borrower)
    {
        $borrower->delete();
        return redirect()->route('borrowers.index')->with('success', 'Borrower deleted successfully!');
    }
}