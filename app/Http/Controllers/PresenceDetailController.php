<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Support\Facades\Storage;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;

class PresenceDetailController extends Controller
{
    public function destroy($id)
    {
        $presenceDetail = PresenceDetail::findOrFail($id);

        if ($presenceDetail->tanda_tangan) {
            // Delete the image from storage
            Storage::disk('public_uploads')->delete($presenceDetail->tanda_tangan);
        }

        $presenceDetail->delete();
        return redirect()->back();
    }
}
