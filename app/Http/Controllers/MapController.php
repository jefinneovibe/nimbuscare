<?php

namespace App\Http\Controllers;

use App\testCollection;
use App\User;
use Illuminate\Http\Request;

class MapController extends Controller
{
	//test function save map 
   public function testSave($test1,$test2)
   {
	   $test1=25.0750853;
	   $test2=54.947563;
	   $event=new testCollection();
	   $event->location = ['type' => 'Point', 'coordinates' => [$test1,$test2]];
	   $event->save();
   }
   
   //view map page
   function ViewMap()
   {
   	$users=User::where('isActive',1)->orderBy('name')->get();
	return view('dispatch.view_map')->with(compact('users'));
   }
	
   /**
	* get map for live location and delivery report
    */
   function getMap(Request $request)
   {
   	   $agent=$request->input('id');
   	   $date=$request->input('date');
	   $mapId=$request->input('mapId');
	//    var_dump($agent,$date,$mapId);
	//    dd($mapId);
	   if($mapId=='button_live_view')
	   {
		   $testArray=[];
		   if($agent!='' && $date!='')
		   {
			   $user=User::find($agent);
			   if(isset($user['liveLocation'])) {
				   $mapData = $user['liveLocation'];
				   foreach ($mapData as $data) {
//					   if (isset($data['deliveryDate']) && $data['deliveryDate'] == $date) {
//			       	   $detailsArray[]=$data['updateBy'];
//			       	   $detailsArray[]=$data['deliveryTime'];
//				       $testArray[]=$data['location']['coordinates'];
//				       $testArray1[]= array_push($testArray, $detailsArray);
//				       dd($testArray1);
						
						   $array1 = $data['location']['coordinates'];
						   $array2 = array($data['updateBy'],$data['deliveryTime']);
						   $testArray[] = array_merge($array1, $array2);
						
//					   }
//					   else {
//						   $testArray[] = 'empty';
//					   }
				   }
			   }
			   else{
				   $testArray='empty';
			   }
			   return $testArray;
		   }
		   else{
			   return 0;
		   }
	   }
	   
	   else {
		   $testArray=[];
		   if($agent!='' && $date!='')
		   {
			   $user=User::find($agent);
			   if(isset($user['MapDetails']))
			   {
				   $mapData=$user['MapDetails'];
				   foreach ($mapData as $data)
				   {
					   if(isset($data['deliveryDate']) && $data['deliveryDate']==$date)
					   {
//			       	   $detailsArray[]=$data['updateBy'];
//			       	   $detailsArray[]=$data['deliveryTime'];
//				       $testArray[]=$data['location']['coordinates'];
//				       $testArray1[]= array_push($testArray, $detailsArray);
//				       dd($testArray1);
						
						   $array1 = $data['location']['coordinates'];
						   $array2 = array($data['updateBy'],$data['deliveryTime'],$data['deliveryDate']);
						   $testArray[] = array_merge($array1, $array2);
					   }
					   else{
						   $testArray[]='empty';
					   }
				   }
			   }
			   else{
				   $testArray='empty';
			   }
			   return $testArray;
		   }
		   else{
			   return 0;
		   }
	   	
	   }
	  
      
   }
   
}
