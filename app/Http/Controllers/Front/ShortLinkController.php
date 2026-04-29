<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Link;

class ShortLinkController extends Controller
{
    public function redirect(string $shortCode)
    {
        $mainWebsite = config('app.main_website_url', '/');

        $link = Link::where('short_code', $shortCode)
            ->where('is_active', true)
            ->first();

        if (! $link) {
            return redirect()->away($mainWebsite);
        }

        // Check if the link has expired
        if ($link->expires_at && $link->expires_at->isPast()) {
            return redirect()->away($mainWebsite);
        }

        // Increment click count
        $link->increment('clicks');

        return redirect()->away($link->original_url);
    }
}
