<?php


namespace App\Http\View\Composers;

use App\Repositories\CategoryRepository;
use Illuminate\View\View;

class BlogComposer
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function compose(View $view)
    {
        $view->with([
            'categories' => $this->categoryRepository->getAll()
        ]);
    }
}
