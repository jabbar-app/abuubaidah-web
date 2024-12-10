<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MustawaRobi;
use App\Models\MustawaTamhidy;
use App\Models\MustawaAwwal;
use App\Models\MustawaTsani;
use App\Models\MustawaTsalits;

class MustawaController extends Controller
{
    public function edit($type, $id)
    {
        $modelClass = $this->getMustawaModel($type);
        $data = $modelClass::findOrFail($id);

        return view('admin.mustawa.edit', compact('data', 'type'));
    }

    public function update(Request $request, $type, $id)
    {
        $modelClass = $this->getMustawaModel($type);
        $data = $modelClass::findOrFail($id);

        $data->update($request->all());

        return redirect()->route('mustawa.index')->with('success', 'Data updated successfully');
    }

    protected function getMustawaModel($mustawa)
    {
        $mustawaModelMap = [
            'robi' => MustawaRobi::class,
            'tamhidy' => MustawaTamhidy::class,
            'awwal' => MustawaAwwal::class,
            'tsani' => MustawaTsani::class,
            'tsalit' => MustawaTsalits::class,
        ];

        $modelClass = $mustawaModelMap[strtolower($mustawa)] ?? null;

        if ($modelClass === null) {
            throw new \Exception("Invalid mustawa type");
        }

        return $modelClass;
    }
}
