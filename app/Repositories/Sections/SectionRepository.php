<?php

namespace App\Repositories\Sections;

use App\Repositories\Sections\SectionRepositoryInterface;
use App\Models\Section;


class SectionRepository implements SectionRepositoryInterface {
    public function index()
    {
        $sections = Section::all();
        return view('Dashboard.Sections.index', compact('sections'));
    }
}