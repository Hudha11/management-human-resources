<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function index($slug)
    {
        $presence = Presence::where('slug', $slug)->first();
        $presenceDetails = PresenceDetail::where('presence_id', $presence->id)->get();
        return view('pages.absen.index', compact('presence', 'presenceDetails'));
    }

    public function save(Request $request, string $id)
    {
        $presence = Presence::findOrFail($id);
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'asal_instansi' => 'required',
            'signature' => 'required',
        ]);

        $presenceDetail = new PresenceDetail();
        $presenceDetail->presence_id = $presence->id;
        $presenceDetail->nama = $request->nama;
        $presenceDetail->jabatan = $request->jabatan;
        $presenceDetail->asal_instansi = $request->asal_instansi;

        // decode base64 image
        $base46_image = $request->signature;
        @list($type, $file_data) = explode(';', $base46_image);
        @list(, $file_data) = explode(',', $file_data);

        // generate name file
        $uniqChar = date('YmdHis') . uniqid();
        $signature = "tanda-tangan/{$uniqChar} . png";

        // simpan gambar ke public
        Storage::disk('public_uploads')->put($signature, base64_decode($file_data));

        $presenceDetail->tanda_tangan = $signature;
        $presenceDetail->save();

        return redirect()->back();

        // $presence = Presence::find($request->input('presence_id'));
        // $presence->attendees()->create($request->all());

        // return redirect()->route('absen.index', ['slug' => $presence->slug])->with('success', 'Absen berhasil disimpan.');
    }
}
