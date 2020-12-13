<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ScreensController extends Controller
{
    public function getScreens(Request $req)
    {
        $left_image = $this->getLeftImage();
        $left_image = (object)$left_image;

        $right_image = $this->getRightImage($left_image->id);
        $right_image = (object)$right_image;

        if ($left_image == null || $right_image == null)
        {
            $new_screen = "";
        }
        else
        {
            $new_screen = "
                    <div 
                        class=\"image left-image\" 
                        onclick=\"
                            like_id('$left_image->id');
                            delete_id('$right_image->id');
                            go_next_screen()
                            \" 
                        name=\"$left_image->id\"
                        style=\"background-image: url('$left_image->url');\"></div>
                    <div 
                        class=\"image right-image\" 
                        onclick=\"
                            like_id('$right_image->id');
                            delete_id('$left_image->id');
                            go_next_screen()
                            \"
                            name=\"$right_image->id\"
                        style=\"background-image: url('$right_image->url');\"></div>
                        

                    <div class=\"name left-name\">$left_image->name</div>
                    <div class=\"name right-name\">$right_image->name</div>
            ";
        }

        return $new_screen;
    }

    function getLeftImage()
    {
        return $this->getRandomImage();
    }

    function getRightImage($id_to_ignore)
    {
        return $this->getRandomImage($id_to_ignore);
    }

    public function getRandomImage($id_to_ignore = null)
    {
        $girl = DB::table('girls')
                    ->inRandomOrder()
                    ->first();
        if ($girl != null)
        {
            // if it is the same image - select another random image 
            if ($id_to_ignore == $girl->id)
            {
                return $this->getRandomImage($id_to_ignore);
            }

            $response =
            [
                "id" => $girl->id,
                "url" => $girl->photo_url,
                "name" => $girl->instagram_username
            ];

            return $response;
        }
        
        return null;
    }

    public function increaseViews(Request $req)
    {
        return $this->increaseViewId(($req->input())['id']);
    }

    function addUsers()
    {
        $access_token = "nefCaNF9w2PqrUKQsSFHcL9rw6uoMqwMiYBn8vxkTA0";
        
        $data = 
        [
            "client_id" => $access_token,
            "query" => "woman",
            "orientation" => "portrait",
            "count" => 30
        ];

        $items = [];
        
        for ($i = 0; $i < 10; $i++)
        {
            $response = Http::get('https://api.unsplash.com/photos/random', $data);
            $response = (object)(json_decode($response, true));
    
            foreach ($response as $item)
            {
                $item = (object)$item;
                $new_item = 
                [
                    "id"         => $item->id,
                    "first_name" => $item->user['first_name'],
                    "last_name"  => $item->user['last_name'],
                    "instagram_username"  => $item->user['instagram_username'],
                    "photo_url"  => $item->urls['regular'],
                ];
                
                $new_item = (object)$new_item;

                $rows = DB::select("select * from girls where id = ?", [$new_item->id]);
                if (count($rows) != 0)
                {
                    continue;
                }

                DB::insert("insert into girls
                    (
                        id,
                        first_name,
                        last_name,
                        instagram_username,
                        photo_url
                    ) values
                    (
                        ?,
                        ?,
                        ?,
                        ?,
                        ?
                    )
                ", [
                    $new_item->id,
                    $new_item->first_name,
                    $new_item->last_name,
                    $new_item->instagram_username,
                    $new_item->photo_url
                ]);

                $items[] = $new_item;
            }
        }

        return $items;

        // old - not using now, but left for memory
        // ------------------------------- VK -------------------------------------------------------

        // $access_token = "0c594d901ff851c711b3c480ccea2d3f5cdd09efa4ec7ceb13c41d82b109d5eaadd7c7dec1ded4f87875c";
        // $user_id = "1";
        // $v = "5.21";
        // $count = 1000;
        // $fields = implode(",",
        //     [
        //         "sex",
        //         "has_photo",
        //         "photo_max_orig"
        //     ]);

        // $items = [];

        // for ($i = 0; $i < 5; $i++)
        // {
        //     $data = 
        //     [
        //         "access_token" => $access_token,
        //         "user_id" => $user_id,
        //         "v" => $v,
        //         "count" => $count,
        //         "offset" => $i * $count,
        //         "fields" => $fields
        //     ];

        //     $response = Http::get('https://api.vk.com/method/users.getFollowers', $data);
        //     $response = ((object)(json_decode($response, true)))->response;

        //     foreach ($response['items'] as $item)
        //     {
        //         if ($item['sex'] == 1 && $item['has_photo'] == 1)
        //         {
        //             $new_item = 
        //             [
        //                 "id" => $item['id'],
        //                 "first_name" => $item['first_name'],
        //                 "last_name" => $item['last_name'],
        //                 "photo_url" => $item['photo_max_orig'],
        //             ];
        //             $new_item = (object)$new_item;

        //             $rows = DB::select("select * from girls where id = ?", [$new_item->id]);
        //             if (count($rows) != 0)
        //             {
        //                 continue;
        //             }

        //             DB::insert("insert into girls
        //                 (
        //                     id,
        //                     first_name,
        //                     last_name,
        //                     photo_url
        //                 ) values
        //                 (
        //                     ?,
        //                     ?,
        //                     ?,
        //                     ?
        //                 )
        //             ", [
        //                 $new_item->id,
        //                 $new_item->first_name,
        //                 $new_item->last_name,
        //                 $new_item->photo_url
        //             ]);

        //             $items[] = $new_item;
        //         }
        //     }
        // }

        // return $items;
    }

    public function deleteId(Request $req)
    {
        DB::table('girls')->where('id', ($req->input())['id'])->delete();
        $girl = DB::table('girls')
                    ->where('id', ($req->input())['id'])
                    ->first();
        if ($girl != null)
        {
            return "delete failed";
        } else
        {
            return "girl with id " . ($req->input())['id'] . " no longer exits in database";
        }
    }

    public function likeId(Request $req)
    {
        $clicks = DB::table('girls')->where('id', ($req->input())['id'])->pluck('clicks')->first();
        DB::table('girls')->where('id', ($req->input())['id'])->update(['clicks' => $clicks + 1]);
        return "ok";
    }

    function increaseViewId($id)
    {
        $views = DB::table('girls')->where('id', $id)->pluck('views')->first();
        DB::table('girls')->where('id', $id)->update(['views' => $views + 1]);
        return "ok";
    }

    function zeroViewsClicks()
    {
        DB::table('girls')->update(['clicks' => 0]);
        DB::table('girls')->update(['views' => 0]);
    }

    public function convertCyrillicToLatin()
    {
        $rows = DB::table('girls')->get();
        foreach ($rows as $row)
        {
            $first_name = $this->convertCyrillic($row->first_name);
            $last_name = $this->convertCyrillic($row->last_name);
            DB::table('girls')->where('id', $row->id)->update(['first_name' => $first_name, 'last_name' => $last_name]);
        }
    }

    function convertCyrillic($name)
    {
        $cyr = [
            'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
        ];
        $lat = [
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
        ];
        $namecyr = str_replace($cyr, $lat, $name);
        return $namecyr;
    }

    public function addGirl(Request $req)
    {
        $url = ($req->input())['photo_url'];
        $first_name = ($req->input())['first_name'];
        $last_name = ($req->input())['last_name'];

        $girl = DB::table('girls')->where('photo_url', $url)->get()->first();
        if ($girl != null)
        {
            return response()->json([
                'error' => 'Such girl already exists in database'], 403);
        }

        DB::table('girls')->insert([
            //'id' => getNewId(),
            'first_name' => $first_name, 
            'last_name' => $last_name,
            'photo_url' => $url 
        ]);

        return "oki";
    }

    function getNewId()
    {
        $rand = substr(md5(microtime()),rand(0,26),10);

        $id = DB::table('girls')->where('id', $rand)->get()->first();
        if ($id != null)
        {
            // If such randomly generated ID already exists - generate a new one
            return getNewId();
        }

        return $rand;
    }
}