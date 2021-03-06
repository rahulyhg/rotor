<?php

declare(strict_types=1);

namespace App\Controllers\Load;

use App\Controllers\BaseController;
use App\Models\Down;
use App\Models\Load;
use Illuminate\Http\Request;

class LoadController extends BaseController
{
    /**
     * Главная страница
     *
     * @return string
     */
    public function index(): string
    {
        $categories = Load::query()
            ->where('parent_id', 0)
            ->with('children', 'new', 'children.new')
            ->orderBy('sort')
            ->get();

        if ($categories->isEmpty()) {
            abort('default', 'Разделы загрузок еще не созданы!');
        }

        return view('loads/index', compact('categories'));
    }

    /**
     * Список файлов в категории
     *
     * @param int     $id
     * @param Request $request
     * @return string
     */
    public function load(int $id, Request $request): string
    {
        /** @var Load $category */
        $category = Load::query()->with('parent')->find($id);

        if (! $category) {
            abort(404, 'Данной категории не существует!');
        }

        $total = Down::query()->where('category_id', $category->id)->where('active', 1)->count();
        $page = paginate(setting('downlist'), $total);

        $sort = check($request->input('sort'));

        switch ($sort) {
            case 'rated':
                $order = 'rated';
                break;
            case 'comments':
                $order = 'count_comments';
                break;
            case 'loads':
                $order = 'loads';
                break;
            default:
                $order = 'created_at';
        }

        $downs = Down::query()
            ->where('category_id', $category->id)
            ->where('active', 1)
            ->orderBy($order, 'desc')
            ->offset($page->offset)
            ->limit($page->limit)
            ->get();

        return view('loads/load', compact('category', 'downs', 'page', 'order'));
    }

    /**
     * RSS всех файлов
     *
     * @return string
     */
    public function rss(): string
    {
        $downs = Down::query()
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        if ($downs->isEmpty()) {
            abort('default', 'Файлы не найдены!');
        }

        return view('loads/rss', compact('downs'));
    }
}
