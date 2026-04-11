<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    /**
     * Display a listing of the associations.
     */
    public function index()
    {
        $associations = Association::with('user')->get();
        return view('associations.index', compact('associations'));
    }

    /**
     * Display the specified association.
     */
    public function show($id)
    {
        $association = Association::with(['user', 'activities'])->findOrFail($id);
        return view('associations.show', compact('association'));
    }
}
