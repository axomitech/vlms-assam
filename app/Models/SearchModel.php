<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SearchModel extends Model
{
    use HasFactory;

    public static function get_letter_search($inputData)
    {
        $query = DB::table('letters')
            ->leftJoin('senders', 'letters.id', '=', 'senders.letter_id')
            ->leftJoin('recipients', 'letters.id', '=', 'recipients.letter_id')
            ->join('letter_categories', 'letters.letter_category_id', '=', 'letter_categories.id')
            ->join('letter_sub_categories', 'letters.letter_sub_category_id', '=', 'letter_sub_categories.id')
            ->select(
                'letters.*',
                'senders.*',
                'recipients.*',
                'senders.organization as sender_organization',
                'recipients.organization as recipient_organization',
                'letter_categories.*',
                'letter_sub_categories.*'
            );

        // Add text search filter
        if (!empty($inputData['text_search'])) {
            $searchTerm = strtolower($inputData['text_search']);
            $query->where(function ($q) use ($searchTerm) {
                $q->orWhere(DB::raw('lower(REPLACE(letter_no, \'\\\\\', \'\'))'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(subject)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(senders.organization)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(recipients.organization)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(senders.sender_name)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(recipients.recipient_name)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(senders.sender_email)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(recipients.recipient_email)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(letter_categories.category_name)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('lower(letter_sub_categories.sub_category_name)'), 'like', '%' . $searchTerm . '%');
            });
        }

        // Other filters (e.g., category, subcategory)
        if (!empty($inputData['category'])) {
            $query->where('letters.letter_category_id', '=', $inputData['category']);
        }

        if (!empty($inputData['subcategory'])) {
            $query->where('letters.letter_sub_category_id', '=', $inputData['subcategory']);
        }

        if (!empty($inputData['received_from']) && !empty($inputData['received_to'])) {
            $query->whereBetween('received_date', [$inputData['received_from'], $inputData['received_to']]);
        }

        // Filter by department (except for system admin)
        if (session()->has('role_dept') && session('role_dept') != 1) {
            $query->where('letters.department_id', '=', session('role_dept'));
        }

        $query->orderBy('letters.id', 'desc');

        return $query->get();
    }

    public static function get_all_letter_categories()
    {
        return DB::table('letter_categories')
            ->get();
    }

    public static function get_all_letter_subcategories()
    {
        return DB::table('letter_sub_categories')
            ->get();
    }
}
