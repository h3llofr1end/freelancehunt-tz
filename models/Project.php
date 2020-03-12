<?php


namespace app\models;


use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public static function refreshData($db)
    {
        $db::table('projects')->delete();
        $skills = [];

        $categories = Category::all();
        foreach($categories as $category) {
            $skills[] = $category->id;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.freelancehunt.com/v2/projects?filter[skill_id]=1&filter[skill_id]=".implode(',',$skills),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$_ENV['FREELANCEHUNT_API_KEY']
            ),
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        self::saveResponse($db, $response);

        $nextLink = $response->links->next;
        $stop = false;

        while(!$stop || $nextLink !== '') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $nextLink,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer ".$_ENV['FREELANCEHUNT_API_KEY']
                ),
            ));

            $response = json_decode(curl_exec($curl));

            curl_close($curl);

            self::saveResponse($db, $response);

            $nextLink = isset($response->links->next) ? $response->links->next : '';

            $stop = !isset($response->links->last);

            if(!isset($response->links->last)) {
                break;
            }
        }
    }

    public static function saveResponse($db, $response)
    {
        foreach($response->data as $project) {
            $projectModel = $db::table('projects')->insertGetId([
                'link' => $project->links->self->web,
                'amount' => !empty($project->attributes->budget) ? $project->attributes->budget->amount : 0,
                'name' => !empty($project->attributes->employer) ? $project->attributes->employer->first_name.' '.$project->attributes->employer->last_name : NULL,
                'login' => !empty($project->attributes->employer) ? $project->attributes->employer->login : NULL,
            ]);

            foreach($project->attributes->skills as $skill) {
                if(in_array($skill->name, Category::NEEDLE_CATEGORIES)) {
                    $db::table('project_categories')->insert([
                        'project_id' => $projectModel,
                        'category_id' => $skill->id
                    ]);
                }
            }
        }
    }
}
