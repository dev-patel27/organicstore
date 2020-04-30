<?php
class Api_model extends CI_Model {

    function __construct(){

        parent::__construct();
    }


     public function validation($input, $postinput)
	{
		$arr = array();
		foreach ($postinput as $key => $post) {
			if ($post != '') {
				$arr[] = $key;
			}
		}
		$result = array_diff($input, $arr);
		$diff[] = $result;
		return $result;
	}

	public function validationField($requiredData)
	{
		foreach ($requiredData as $key => $value) {
			$datamissing = $value;
		}
		$data['status'] = 0;
		$data['message'] = $datamissing . ' is required';
		return $data;
	}
	
	public function sendPushNotification( $device_token, $device_type, $message, $type, $object_id ){
	
		$iosApnsCert = BASE_UPLOAD_DIR.'dev.pem';
		$registration_id = $device_token;

		if( $device_type == '1' ){
		
		   // $ssl_url            = 'ssl://gateway.push.apple.com:2195';
		    $ssl_url                = 'ssl://gateway.sandbox.push.apple.com:2195'; //For Test
		
		    $payload = array();
		    $payload['aps'] = array('alert' => array("body"=>$message, "action-loc-key"=>"View"), 'sound' => 'default');
		    ## notice : alert, badge, sound
		
		
		    ## $payload['extra_info'] is different from what your app is programmed, this extra_info transfer to your IOS App
		   // $payload['extra_info'] = array('apns_msg' => $message);
		    $payload['type'] = $type;
		    $payload['id'] = $object_id;
		    $push = json_encode($payload);
		
		    //Create stream context for Push Sever.
		    $streamContext = stream_context_create();
		    stream_context_set_option($streamContext, 'ssl', 'local_cert', $iosApnsCert);
		
		    $apns = stream_socket_client($ssl_url, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
		
		
		    if (!$apns) {
		
		        $rtn["code"]   = "001";
		        $rtn["msg"]       = "Failed to connect ".$error." ".$errorString;
		        //return $rtn;
		       // pr($rtn);
		    }else{
		
		
		        $t_registration_id = str_replace('%20', '', $registration_id);
		        $t_registration_id = str_replace(' ', '', $t_registration_id);
		        $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $t_registration_id)) . chr(0) . chr(strlen($push)) . $push;
		
		        $writeResult = fwrite($apns, $apnsMessage);
		        fclose($apns);
		
		
		
		        $rtn["code"]   = "000";//means result OK
		        $rtn["msg"]       = "OK";
		        //pr($rtn);
		    }
		
		
		
		
		}
		
		if($device_type == '2'){
		
		    $androidAuthKey = "AIzaSyCDFcctPPlrw4YI_cjQtt2PIiZGRmsCqzE";//Auth Key Herer
		
		    ## data is different from what your app is programmed
		    $data = array(
		        'registration_ids' => $registration_id,
		        'type' => $type,
		        'data' => array(
		            'gcm_msg'     => $message
		        )
		    );
		
		
		    $headers = array(
		        "Content-Type:application/json",
		        "Authorization:key=".$androidAuthKey
		    );
		
		
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		    $result = curl_exec($ch);
		    //result sample {"multicast_id":6375780939476727795,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1390531659626943%6cd617fcf9fd7ecd"}]}
		    //http://developer.android.com/google/gcm/http.html  // refer error code
		    curl_close($ch);
		
		    $rtn["code"]   = "000";//means result OK
		    $rtn["msg"]       = "OK";
		    $rtn["result"] = $result;
		    //return $rtn;
		
		}
	}

}
?>