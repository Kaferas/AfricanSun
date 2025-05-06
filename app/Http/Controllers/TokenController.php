<?php

namespace App\Http\Controllers;

use App\Models\Kit;
use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $tokenQuery = Token::query();

        if ($request->has('search') && $search != null && !empty($search)) {
            $tokenQuery->whereHas('kit', function ($query) use ($search) {
                $query->where('kit_serial_number', 'like', '%' . $search . '%');
            });
        }

        $tokenQuery->with(['kit','user']);

        if ($request->has('start_date') && $start_date != null && !empty($start_date)) {
            $tokenQuery->where('created_at', '>=', $start_date);
        }

        if ($request->has('end_date') && $end_date != null && !empty($end_date)) {
            $tokenQuery->where('created_at', '<=', $end_date);
        }

        $tokens = $tokenQuery->latest()->paginate(100);
        
        return view('token.index',[
            "search" => $search,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "tokens" => $tokens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kits = Kit::withCount('token')->get();

        return view('token.form',compact('kits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'kit_id.required' => 'Le champ Kit est obligatoire.',
            'kit_id.exists' => 'Le Kit sélectionné n\'existe pas.',
            'generated_token.required' => 'Le jeton généré est obligatoire.',
            'generated_token.unique' => 'Ce jeton existe déjà.',
            'token_type.required' => 'Le type de jeton est obligatoire.',
            'token_type.in' => 'Le type de jeton doit être crédit, déverrouillage ou réinitialisation.'
        ];

        $validated = $request->validate([
            'kit_id' => 'required|exists:kits,id',
            'generated_token' => 'required|string|unique:tokens,generated_token',
            'token_type' => 'required|in:credit,unlock,reset'
        ],$messages);

        $validated['created_by'] = auth()->user()->id;

        $token = Token::create($validated);

        return redirect()
            ->route('token.index')
            ->with('success', 'Token créé avec succé');
    }

    /**
     * Display the specified resource.
     */
    public function show(Token $token)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Token $token)
    {
        $kits = Kit::all();

        return view('token.form',compact('kits','token'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Token $token)
    {
        $messages = [
            'kit_id.required' => 'Le champ Kit est obligatoire.',
            'kit_id.exists' => 'Le Kit sélectionné n\'existe pas.',
            'generated_token.required' => 'Le jeton généré est obligatoire.',
            'generated_token.unique' => 'Ce jeton existe déjà.',
            'end_token_date.required' => 'La date de fin du jeton est obligatoire.',
            'token_type.required' => 'Le type de jeton est obligatoire.',
            'token_type.in' => 'Le type de jeton doit être crédit, déverrouillage ou réinitialisation.'
        ];

        $validated = $request->validate([
            'kit_id' => 'required|exists:kits,id',
            'generated_token' => 'required|string|unique:tokens,generated_token,'.$token->id,
            'end_token_date' => 'required',
            'token_type' => 'required|in:credit,unlock,reset'
        ],$messages);

        $validated['created_by'] = auth()->user()->id;

        $token->update($validated);

        return redirect()
            ->route('token.index')
            ->with('success', 'Token mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Token $token)
    {
        //
    }
}
