<?php

namespace App\Http\Controllers;

use App\Helpers\OpenGraphHelper;
use App\Models\Incident;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function getMetaTags(Request $request)
    {
        $path = $request->query('path', '/');
        $segments = explode('/', ltrim($path, '/'));
        
        // Handle incident detail pages
        if (count($segments) === 2 && $segments[0] === 'incident' && isset($segments[1])) {
            $incidentId = $segments[1];
            $incident = Incident::find($incidentId);
            
            if ($incident) {
                $data = [
                    'title' => $incident->title,
                    'description' => substr(strip_tags($incident->description), 0, 160),
                    'url' => config('app.url') . '/incident/' . $incidentId,
                ];
                
                // If incident has media, use the first image as OG image
                if ($incident->media && $incident->media->count() > 0) {
                    $firstMedia = $incident->media->first();
                    if ($firstMedia && in_array($firstMedia->file_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                        $data['image'] = config('app.url') . '/storage/' . $firstMedia->file_path;
                    }
                }
                
                return response()->json(OpenGraphHelper::generateMetaTags('incident', $data));
            }
        }
        
        // Handle other specific routes
        $pageMap = [
            'map' => 'map',
            'report' => 'report',
            'analytics' => 'analytics',
            'admin' => 'admin',
            'login' => 'login',
            'register' => 'register',
            'profile' => 'profile',
            'my-reports' => 'my-reports',
            'my-activity' => 'my-activity',
        ];
        
        $page = $pageMap[$segments[0]] ?? 'home';
        $url = config('app.url') . ($path === '/' ? '' : $path);
        $data = [
            'url' => $url,
        ];
        
        return response()->json(OpenGraphHelper::generateMetaTags($page, $data));
    }
}
