<?php


namespace app\models;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const NEEDLE_CATEGORIES = [
        'Веб-программирование',
        'PHP',
        'Базы данных'
    ];

    public static function refreshData($db)
    {
        $db::table('categories')->delete();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.freelancehunt.com/v2/skills",
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

        foreach($response->data as $category)
        {
            if(in_array($category->name, self::NEEDLE_CATEGORIES)) {
                $db::table('categories')->insert([
                    'id' => $category->id,
                    'name' => $category->name
                ]);
            }
        }
    }
}
