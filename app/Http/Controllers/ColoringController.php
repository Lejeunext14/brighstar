<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ColoringController extends Controller
{
    /**
     * Search OpenClipart for coloring designs
     */
    public function searchOpenClipart(Request $request)
    {
        $query = $request->get('q', 'animal');
        $limit = $request->get('limit', 20);
        
        try {
            // Try HTTP instead of HTTPS
            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'])
                ->get('http://openclipart.org/api/collections/search', [
                    'query' => $query,
                    'limit' => $limit,
                    'page' => 0,
                    'sort' => 'downloads'
                ]);
            
            \Log::info('OpenClipart response status: ' . $response->status());
            \Log::info('OpenClipart response body: ' . substr($response->body(), 0, 1000));
            
            if ($response->successful()) {
                $data = $response->json();
                $designs = $this->parseApiResponse($data);
                
                if (count($designs) > 0) {
                    return response()->json([
                        'success' => true,
                        'designs' => $designs,
                        'count' => count($designs)
                    ]);
                }
            }
            
            // Fallback: Return mock designs based on query
            $mockDesigns = $this->getMockDesigns($query, $limit);
            if (count($mockDesigns) > 0) {
                return response()->json([
                    'success' => true,
                    'designs' => $mockDesigns,
                    'count' => count($mockDesigns),
                    'note' => 'Sample designs - live search temporarily unavailable'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'error' => 'No designs found.',
                'debug' => [
                    'query' => $query,
                    'response_status' => $response->status() ?? 'N/A'
                ]
            ], 404);
            
        } catch (\Exception $e) {
            \Log::error('OpenClipart search error: ' . $e->getMessage());
            
            // Fallback to mock designs
            $mockDesigns = $this->getMockDesigns($query, $limit);
            if (count($mockDesigns) > 0) {
                return response()->json([
                    'success' => true,
                    'designs' => $mockDesigns,
                    'count' => count($mockDesigns),
                    'note' => 'Sample designs - using fallback'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch designs: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Get mock/sample designs for fallback
     */
    private function getMockDesigns($query, $limit)
    {
        $allDesigns = [
            [
                'id' => 'mock_1',
                'title' => 'Butterfly Design',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Ccircle cx="100" cy="100" r="50" fill="none" stroke="black" stroke-width="2"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'butterfly animal insect nature'
            ],
            [
                'id' => 'mock_2',
                'title' => 'Flower Pattern',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Cpath d="M100 50 L120 100 L100 150 L80 100 Z" fill="none" stroke="black" stroke-width="2"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'flower plant nature garden'
            ],
            [
                'id' => 'mock_3',
                'title' => 'Star Shape',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Cpolygon points="100,10 120,80 190,80 150,130 170,200 100,160 30,200 50,130 10,80 80,80" fill="none" stroke="black" stroke-width="2"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'star shape space geometric'
            ],
            [
                'id' => 'mock_4',
                'title' => 'Mandala',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Ccircle cx="100" cy="100" r="100" fill="none" stroke="black" stroke-width="1"/%3E%3Ccircle cx="100" cy="100" r="75" fill="none" stroke="black" stroke-width="1"/%3E%3Ccircle cx="100" cy="100" r="50" fill="none" stroke="black" stroke-width="1"/%3E%3Ccircle cx="100" cy="100" r="25" fill="none" stroke="black" stroke-width="1"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'mandala geometric pattern art'
            ],
            [
                'id' => 'mock_5',
                'title' => 'Tree',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Crect x="80" y="120" width="40" height="60" fill="none" stroke="black" stroke-width="2"/%3E%3Ccircle cx="100" cy="80" r="40" fill="none" stroke="black" stroke-width="2"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'tree plant nature forest'
            ],
            [
                'id' => 'mock_6',
                'title' => 'Heart',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Cpath d="M100 150 C50 120 20 100 20 70 C20 50 35 35 50 35 C65 35 85 45 100 60 C115 45 135 35 150 35 C165 35 180 50 180 70 C180 100 150 120 100 150 Z" fill="none" stroke="black" stroke-width="2"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'heart love shape'
            ],
            [
                'id' => 'mock_7',
                'title' => 'Dancing Cat',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Ccircle cx="100" cy="120" r="30" fill="none" stroke="black" stroke-width="2"/%3E%3Ccircle cx="100" cy="70" r="25" fill="none" stroke="black" stroke-width="2"/%3E%3Cline x1="75" y1="50" x2="60" y2="35" stroke="black" stroke-width="2"/%3E%3Cline x1="125" y1="50" x2="140" y2="35" stroke="black" stroke-width="2"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'cat animal pet mammal'
            ],
            [
                'id' => 'mock_8',
                'title' => 'Friendly Fish',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Cellipse cx="100" cy="100" rx="40" ry="30" fill="none" stroke="black" stroke-width="2"/%3E%3Cpath d="M140 100 L180 80 L180 120 Z" fill="none" stroke="black" stroke-width="2"/%3E%3Ccircle cx="115" cy="95" r="4" fill="black"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'fish animal water ocean sea'
            ],
            [
                'id' => 'mock_9',
                'title' => 'Happy Dog',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Ccircle cx="100" cy="110" r="35" fill="none" stroke="black" stroke-width="2"/%3E%3Ccircle cx="100" cy="60" r="28" fill="none" stroke="black" stroke-width="2"/%3E%3Ccircle cx="85" cy="45" r="8" fill="none" stroke="black" stroke-width="2"/%3E%3Ccircle cx="115" cy="45" r="8" fill="none" stroke="black" stroke-width="2"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'dog animal pet mammal'
            ],
            [
                'id' => 'mock_10',
                'title' => 'Sunny Rainbow',
                'svg_url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Cpath d="M50 150 Q100 80 150 150" fill="none" stroke="black" stroke-width="3"/%3E%3Ccircle cx="100" cy="160" r="20" fill="none" stroke="black" stroke-width="2"/%3E%3C/svg%3E',
                'preview_url' => null,
                'author' => 'BrightStar Sample',
                'tags' => 'rainbow nature weather sun'
            ]
        ];
        
        // Filter by query if provided
        $filtered = [];
        $lowerQuery = strtolower($query);
        
        foreach ($allDesigns as $design) {
            if (empty($lowerQuery)) {
                $filtered[] = $design;
            } else {
                $titleMatch = strpos(strtolower($design['title']), $lowerQuery) !== false;
                $tagMatch = strpos(strtolower($design['tags']), $lowerQuery) !== false;
                $idMatch = strpos(strtolower($design['id']), $lowerQuery) !== false;
                
                if ($titleMatch || $tagMatch || $idMatch) {
                    $filtered[] = $design;
                }
            }
        }
        
        return array_slice($filtered, 0, $limit);
    }
    
    /**
     * Parse designs from any OpenClipart API response format
     */
    private function parseApiResponse($data)
    {
        $designs = [];
        
        // Handle array of items (flat search response)
        if (is_array($data) && isset($data[0])) {
            foreach ($data as $item) {
                $design = $this->extractDesign($item);
                if ($design) {
                    $designs[] = $design;
                }
            }
            return $designs;
        }
        
        // Handle object with results property
        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $item) {
                $design = $this->extractDesign($item);
                if ($design) {
                    $designs[] = $design;
                }
            }
            return $designs;
        }
        
        // Handle object with data property
        if (isset($data['data']) && is_array($data['data'])) {
            foreach ($data['data'] as $item) {
                $design = $this->extractDesign($item);
                if ($design) {
                    $designs[] = $design;
                }
            }
            return $designs;
        }
        
        return $designs;
    }
    
    /**
     * Extract a single design from various possible data structures
     */
    private function extractDesign($item)
    {
        $svgUrl = null;
        
        // Try various SVG URL locations
        if (isset($item['svg']['url'])) {
            $svgUrl = $item['svg']['url'];
        } elseif (isset($item['svg_url'])) {
            $svgUrl = $item['svg_url'];
        } elseif (isset($item['svg'])) {
            $svgUrl = is_string($item['svg']) ? $item['svg'] : $item['svg']['url'] ?? null;
        } elseif (isset($item['href'])) {
            $svgUrl = $item['href'];
        } elseif (isset($item['url'])) {
            $svgUrl = $item['url'];
        }
        
        if (!$svgUrl) {
            return null;
        }
        
        // Ensure full URL
        if (strpos($svgUrl, 'http') !== 0) {
            $svgUrl = 'https://openclipart.org' . $svgUrl;
        }
        
        return [
            'id' => $item['id'] ?? $item['clipid'] ?? uniqid(),
            'title' => $item['title'] ?? $item['name'] ?? 'Untitled Design',
            'svg_url' => $svgUrl,
            'preview_url' => $item['preview_url'] ?? $item['thumbnail_url'] ?? $item['preview'] ?? null,
            'author' => $item['author'] ?? $item['user_name'] ?? $item['user'] ?? 'Unknown'
        ];
    }
    
    /**
     * Fetch and proxy SVG from OpenClipart to avoid CORS issues
     */
    public function getSvg(Request $request)
    {
        $url = $request->get('url');
        
        // Handle data: URLs (embedded SVG)
        if (strpos($url, 'data:image/svg') === 0) {
            $svgData = substr($url, strpos($url, ',') + 1);
            $body = urldecode($svgData);
            
            return response($body, 200)
                ->header('Content-Type', 'image/svg+xml; charset=utf-8')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Cache-Control', 'public, max-age=86400');
        }
        
        // Validate URL is from openclipart or trusted source
        if (!$url || (strpos($url, 'openclipart.org') === false && strpos($url, 'githubusercontent.com') === false)) {
            return response()->json(['error' => 'Invalid SVG URL'], 400);
        }
        
        try {
            $response = Http::timeout(15)
                ->withoutVerifying()
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'])
                ->get($url);
            
            if ($response->successful()) {
                $body = $response->body();
                
                return response($body, 200)
                    ->header('Content-Type', 'image/svg+xml; charset=utf-8')
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Cache-Control', 'public, max-age=86400');
            }
            
            return response()->json(['error' => 'SVG not found'], 404);
            
        } catch (\Exception $e) {
            \Log::error('SVG fetch error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch SVG: ' . $e->getMessage()], 500);
        }
    }
}
