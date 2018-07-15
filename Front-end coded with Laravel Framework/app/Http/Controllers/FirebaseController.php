<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as req;
use App\Message as mes;
use DB;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use App\User;
use Kreait\Firebase\Messaging\Message;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\MessageToTopic;


class FirebaseController extends Controller
{
    public function index(Request $request)
		{
			$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/hackatrensample-firebase-adminsdk-nce3f-4bb82e9947.json');
			$firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
					$db = $firebase->getDatabase();

					$db->getReference('users')->set([
						'id'=>1,
						'name'=>'michael',
						'email'=>'mjxx77@gmail.com',
						'online'=>1
					]);
					echo '<h1>Data has been inserted.</h1>';
		}

		public function cloudMessaging($token, $message)
		{
			$url = 'https://fcm.googleapis.com/fcm/send';
			$fields = [
				 'registration_ids' => $token,
				 'data' => $message
				];

			$headers = array(
				'Authorization:key = AAAA8yzh_AA:APA91bGhpf4LQmQIfuXW8AVf_9WacdDACMbjI77_TtYnoZ3Lo04HcN1mNzgbpHlAViEO4vmUk8UGU8lEO5fMGGlqjiyUX_nfR5T0DMpDfD8CylWGkSNXsMCg5IEqhcpWTD5dNOm6HANij6FRpltoAtDMMYXlOK3sQA ',
				'Content-Type: application/json'
				);

		   $ch = curl_init();
	       curl_setopt($ch, CURLOPT_URL, $url);
	       curl_setopt($ch, CURLOPT_POST, true);
	       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	       $result = curl_exec($ch);
	       if ($result === FALSE) {
	           die('Curl failed: ' . curl_error($ch));
	       }
	       curl_close($ch);
				 return $result;
		}

    public function try()
		{
			$value = req::input("station_name");
			$message = new mes;
			$token = [];
			$mes = "";

			switch ($value) {
				case '10':
					$mes = ["message"=> "Baclaran Station"];
					break;
				case '22':
					$mes = ["message" => "EDSA Station"];
					break;
				case '34':
					$mes = ["message" => "Libertad Station"];
					break;
				case '46':
					$mes = ["message" => "Gil Puyat Station"];
					break;
				case '58':
					$mes = ["message" => "Vito Cruz Station"];
					break;
				case '70':
					$mes = ["message" => "Quirino Station"];
					break;
				case '82':
					$mes = ["message" => "Pedro Gil Station"];
					break;
				case '94':
					$mes = ["message" => "U.N Avenue Station"];
					break;
				case '106':
					$mes = ["message" => "Central Station"];
					break;
				case '118':
					$mes = ["message" => "Carriedo Station"];
					break;
				case '130':
					$mes = ["message" => "Doroteo Jose Station"];
					break;
				case '142':
					$mes = ["message" => "Bambang Station"];
					break;
				case '154':
					$mes = ["message" => "Tayuman Station"];
					break;
				case '166':
					$mes = ["message" => "Blumentritt Station"];
					break;
				case '178':
					$mes = ["message" => "Abad Santos Station"];
					break;
				case '190':
					$mes = ["message" => "R. Papa Station"];
					break;
				case '202':
					$mes = ["message" => "5th Avenue Station"];
					break;
				case '214':
					$mes = ["message" => "Monumento Station"];
					break;
                                case '226':
					$mes = ["message" => "Balintawak Station"];
					break;
                                case '238':
					$mes = ["message" => "Roosevelt Station"];
					break;

				default:
					return response("false");
					break;
			}
			// return json_encode($mes);
			$user_token = User::all();
			foreach ($user_token as $user) {
				$token[] = $user->token;
			}
			$this->cloudMessaging($token, $mes);

			
			//$message->message = "Arriving at " . $mes[1];
			//$message->save();

			//return response("true");
    }
}
