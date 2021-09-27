<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use App\Models\Client;
use Carbon\Carbon;
use DB;
use DateTime;

class ParserController extends Controller
{
    /* 
      Format JSON file 
    */
    public function parse(Request $request){
        // can be easily adapt to any format if the data can convert on php array[]
        $data = json_decode(File::get($request->file->getRealPath()));
        $this->save($data);

        return redirect()->route('home')->with('status', 'Data base updated!');
    }

    /* 
     Save data into Data Base
    */
    public function save($data){
        /* 
            The function has O(n) time performance

            A problem with a big file is the memory consumption
            Because of the ocurrences dictionary
        */
        $client = [];
        $occurrences= [];
        
        foreach($data as $key => $item){

            $item->date_of_birth = $this->normalize_date($item->date_of_birth);
            $age = $this->calculate_age($item->date_of_birth);
               
            if($age !== null && ($age < 18 || $age > 65))
                continue;

            $hash =  hash('sha256',json_encode($item));

             if(Client::count() > 0)
            {
               
                if(array_key_exists($hash,$occurrences)){
                    $occurrences[$hash]['json']++;
                }else{
                    
                    $dbFounds =  DB::table('client')->where('hash', $hash)->count();
                
                    $occurrences[$hash] = [ 
                        'json' => 1,
                        'db' => $dbFounds,
                    ];
                
                }   

                if($occurrences[$hash]['json'] > $occurrences[$hash]['db']){
                    $client['name'] = $item->name;
                    $client['address'] = $item->address;
                    $client['checked'] = $item->checked;
                    $client['description'] = $item->description;
                    $client['interest'] = $item->interest;
                    $client['date_of_birth'] = $item->date_of_birth;
                    $client['email'] = $item->email;
                    $client['account'] = $item->account;
                    $client['credit_card_type']= $item->credit_card->type;
                    $client['credit_card_number'] = $item->credit_card->number;
                    $client['credit_card_name'] = $item->credit_card->name;
                    $client['credit_card_expirationDate'] = $item->credit_card->expirationDate;
                    $client['credit_card_identical_digits'] = $this->credit_card_identical_digits($item->credit_card->number);
                    $client['hash'] = $hash;
        
                    Client::create($client);  
    
                    $occurrences[$hash]['db']++;
                }
                              
            }else{
                $client['name'] = $item->name;
                $client['address'] = $item->address;
                $client['checked'] = $item->checked;
                $client['description'] = $item->description;
                $client['interest'] = $item->interest;
                $client['date_of_birth'] = $item->date_of_birth;
                $client['email'] = $item->email;
                $client['account'] = $item->account;
                $client['credit_card_type']= $item->credit_card->type;
                $client['credit_card_number'] = $item->credit_card->number;
                $client['credit_card_name'] = $item->credit_card->name;
                $client['credit_card_expirationDate'] = $item->credit_card->expirationDate;
                $client['credit_card_identical_digits'] = $this->credit_card_identical_digits($item->credit_card->number);
                $client['hash'] = $hash;
    
                Client::create($client);  
                
            } 
    
        }

        return;

    }

    public function normalize_date($date){
        if($date == null) 
            return null;

        // handling of dates on format (dd/mm/yyyy)
        if(strpos($date,'/') !== false){
            $pieces = explode('/', $date);
            $aux = $pieces[0];
            $pieces[0] = $pieces[1];
            $pieces[1] = $aux;
            $date = implode('/', $pieces);
        }
       
        $time = strtotime($date);
        
        return date("Y-m-d H:i:s", $time);
    }

    public function calculate_age($date){
        if($date == null) 
            return null;

        $now = new DateTime();
        $birth = new DateTime($date);
        $diff = $now->diff($birth);

        return $diff->y;
    }

    public function credit_card_identical_digits($number){

        for($i = 0; $i < strlen($number)-2 ; $i++) {
        
            if ($number[$i] === $number[$i+1] && $number[$i] === $number[$i+2]) {
                return true;
            }
        }

        return false;
    }


}
