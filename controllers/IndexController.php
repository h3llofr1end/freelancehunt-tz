<?php


namespace app\controllers;

use app\core\View;
use app\models\Category;
use app\models\Project;

class IndexController
{
    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $projects = Project::query()
            ->limit(10)
            ->offset(($page-1) * 10)
            ->get();
        $skillsData = Category::query()->selectRaw('categories.name, COUNT(project_categories.project_id) as count')
            ->leftJoin('project_categories', 'categories.id', '=', 'project_categories.category_id')
            ->groupBy('category_id')
            ->get();
        $totalPage = Project::query()->count() / 10;
        if($totalPage % 10 === 0) $totalPage+1;
        $piechartData = Project::query()->selectRaw('
            COUNT(*) as Total, 
            Sum(CASE WHEN amount < 500 THEN 1 ELSE 0 END) A, 
            Sum(CASE WHEN amount >= 500 AND amount < 1000 THEN 1 ELSE 0 END) B, 
            Sum(CASE WHEN amount >= 1000 AND amount < 5000 THEN 1 ELSE 0 END) C, 
            Sum(CASE WHEN amount >= 5000 AND amount < 10000 THEN 1 ELSE 0 END) D, 
            Sum(CASE WHEN amount >= 10000 THEN 1 ELSE 0 END) E
        ')->first();
        $series = [
            ['name' => 'До 500 грн.', 'y' => (int)$piechartData['A']],
            ['name' => 'От 500 до 1000 грн.', 'y' => (int)$piechartData['B']],
            ['name' => 'От 1000 до 5000 грн.', 'y' => (int)$piechartData['C']],
            ['name' => 'От 5000 до 10000 грн.', 'y' => (int)$piechartData['D']],
            ['name' => 'От 10000 грн.', 'y' => (int)$piechartData['E']],
        ];
        View::renderTemplate('home/index.php', [
            'projects' => $projects,
            'skills' => $skillsData,
            'piechart' => json_encode(array_values($series)),
            'page' => $page,
            'totalPage' => $totalPage
        ]);
    }
}
