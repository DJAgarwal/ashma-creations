<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleReviewService
{
    /**
     * Get Google Reviews data with 1-hour caching.
     *
     * @return array
     */
    public static function getReviewsData(): array
    {
        return Cache::remember('google_places_reviews_live_v3', 3600, function () {
            return self::fetchFromGoogle();
        });
    }

    /**
     * Clear cached Google reviews data.
     *
     * @return void
     */
    public static function clearCache(): void
    {
        Cache::forget('google_places_reviews_live_v3');
        Cache::forget('google_places_reviews_live_v2');
        Cache::forget('google_places_reviews_data_v1');
    }

    /**
     * Fetch reviews directly from Google Places API (New).
     *
     * @return array
     */
    protected static function fetchFromGoogle(): array
    {
        $apiKey = config('services.google.places_api_key');
        $placeId = config('services.google.place_id');
        $reviewUrl = config('services.google.review_url');
        $mapsUrl = config('services.google.maps_url');

        $rating = 5.0;
        $totalReviews = 0;
        $reviews = [];
        $hasLiveReviews = false;

        if (!empty($apiKey) && !empty($placeId)) {
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Goog-Api-Key' => $apiKey,
                    'X-Goog-FieldMask' => 'id,displayName,rating,userRatingCount,reviews,googleMapsUri',
                ])->timeout(8)->get("https://places.googleapis.com/v1/places/{$placeId}?languageCode=en");

                if ($response->successful()) {
                    $data = $response->json();

                    if (!empty($data['rating'])) {
                        $rating = (float) $data['rating'];
                    }
                    if (!empty($data['userRatingCount'])) {
                        $totalReviews = (int) $data['userRatingCount'];
                    }
                    if (!empty($data['googleMapsUri'])) {
                        $mapsUrl = $data['googleMapsUri'];
                    }

                    if (!empty($data['reviews']) && is_array($data['reviews'])) {
                        foreach ($data['reviews'] as $rev) {
                            $reviewText = $rev['text']['text'] ?? ($rev['originalText']['text'] ?? '');
                            if (!empty($reviewText)) {
                                $reviews[] = [
                                    'author_name' => $rev['authorAttribution']['displayName'] ?? 'Google User',
                                    'author_photo' => $rev['authorAttribution']['photoUri'] ?? null,
                                    'author_url' => $rev['authorAttribution']['uri'] ?? null,
                                    'rating' => (int) ($rev['rating'] ?? 5),
                                    'relative_time' => $rev['relativePublishTimeDescription'] ?? 'Recently',
                                    'text' => $reviewText,
                                    'source' => 'google',
                                ];
                            }
                        }
                    }
                } else {
                    Log::warning('Google Places API response: ' . $response->status(), ['body' => $response->body()]);
                }
            } catch (\Throwable $e) {
                Log::error('Error fetching Google Places reviews: ' . $e->getMessage());
            }
        }

        return [
            'rating' => $rating,
            'total_reviews' => $totalReviews,
            'review_url' => $reviewUrl,
            'maps_url' => $mapsUrl,
            'reviews' => $reviews,
        ];
    }
}
