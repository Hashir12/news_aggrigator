<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsCategories = [
            'Head lines' => [],
            'World News' => [
                'International Relations',
                'Global Conflicts',
                'Natural Disasters',
                'Humanitarian Issues',
                'United Nations',
                "Local News",
                "National News",
                "Breaking News",
            ],
            'National News' => [
                'Government & Politics',
                'National Security',
                'Legislation',
                'Law Enforcement',
                'Federal Agencies',
            ],
            'Politics' => [
                'Political Parties',
                'Elections & Voting',
                'Political Leaders',
                'Political Movements',
                'Diplomacy',
                'Policies & Legislation',
            ],
            'Business & Economy' => [
                'Stock Market',
                'Corporate News',
                'Industry Trends',
                'Trade & Commerce',
                'Jobs & Careers',
                'Startups & Entrepreneurship',
            ],
            'Technology' => [
                'Gadgets & Devices',
                'Software & Apps',
                'AI & Robotics',
                'Internet & Cybersecurity',
                'Innovations & Startups',
                'Space & Exploration',
            ],
            'Health' => [
                'Medical Research',
                'Mental Health',
                'Public Health',
                'Diseases & Conditions',
                'Nutrition & Diet',
                'Fitness & Wellness',
            ],
            'Entertainment' => [
                'Movies & TV Shows',
                'Celebrities',
                'Music',
                'Theatre & Performing Arts',
                'Video Games',
                'Streaming Platforms',
            ],
            'Sports' => [
                'Football (Soccer)',
                'Basketball',
                'Tennis',
                'Cricket',
                'Baseball',
                'Olympic Sports',
            ],
            'Science' => [
                'Astronomy & Space',
                'Earth Science',
                'Biology & Genetics',
                'Physics',
                'Environmental Science',
                'Research & Discoveries',
            ],
            'Education' => [
                'K-12 Education',
                'Higher Education',
                'Online Learning',
                'Scholarships & Grants',
                'Educational Technology',
                'School Policies & Reforms',
            ],
            'Environment' => [
                'Climate Change',
                'Conservation',
                'Sustainability',
                'Wildlife & Biodiversity',
                'Renewable Energy',
                'Environmental Policy',
            ],
            'Lifestyle' => [
                'Fashion',
                'Food & Drink',
                'Health & Wellness',
                'Home & Garden',
                'Relationships',
                'Personal Finance',
            ],
            'Opinion' => [
                'Editorials',
                'Commentary',
                'Columns',
                'Letters to the Editor',
                'Op-Eds',
            ],
            'Culture' => [
                'Art & Design',
                'Literature',
                'History & Heritage',
                'Museums & Exhibits',
                'Cultural Events',
                'Traditions & Festivals',
            ],
            'Travel' => [
                'Destinations',
                'Travel Guides',
                'Adventure Travel',
                'Airlines & Airports',
                'Travel Tips',
                'Luxury Travel',
            ],
            'Weather' => [
                'Forecasts',
                'Natural Disasters',
                'Severe Weather',
                'Climate Events',
                'Meteorology',
            ],
            'Finance' => [
                'Personal Finance',
                'Investment',
                'Banking',
                'Real Estate',
                'Taxes & Legislation',
                'Cryptocurrency',
            ],
            'Cryptocurrency' => [
                'Bitcoin',
                'Ethereum',
                'Blockchain',
                'Altcoins',
                'Regulation & Security',
                'Market Trends',
            ],
            'Military & Defense' => [
                'National Security',
                'Defense Industry',
                'Military Strategy',
                'Conflicts & War',
                'Military Technology',
                'Veterans Affairs',
            ],
            'Local News' => [
                'City News',
                'Local Government',
                'Crime & Safety',
                'Local Events',
                'Community News',
                'Local Economy',
            ],
            'Crime & Safety' => [
                'Homicides & Killings',
                'Theft & Burglary',
                'Cybercrime',
                'Law Enforcement',
                'Crime Prevention',
                'Court Cases & Trials',
            ],
            'Food & Drink' => [
                'Recipes',
                'Restaurant Reviews',
                'Cooking Tips',
                'Food Trends',
                'Nutrition',
                'Wine & Beverages',
            ],
            'Automotive' => [
                'Car Reviews',
                'Industry News',
                'Electric Vehicles',
                'Automotive Innovations',
                'Road Safety',
                'Motorsports',
            ],
            'Art & Design' => [
                'Contemporary Art',
                'Visual Arts',
                'Architecture',
                'Photography',
                'Art Exhibitions',
                'Design Trends',
            ],
            'Religion' => [
                'Religious News',
                'Faith & Beliefs',
                'Religious Leaders',
                'Church News',
                'Religious Events',
                'Interfaith Dialogue',
            ]
        ];

        foreach ($newsCategories as $parentCategory => $childCategories) {
            $parentCategoryRecord = new Category(['name' => $parentCategory, 'parent_id' => null]);
            $parentCategoryRecord->save();
            foreach ($childCategories as $category) {
                $subCategoryModel = new Category(['name' => $category, 'parent_id' => $parentCategoryRecord->id]);
                $subCategoryModel->save();
            }
        }
    }
}
