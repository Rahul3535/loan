<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
class RequestLoanController extends BaseController{
    
    function requestLoan(){
   
    	$arrPageData=request()->all();  
    	$loanAmount = $arrPageData['loanAmount'];
    	$loanTerm   = $arrPageData['loanTerm'];
    	$loanToken  = 'AS'.date('ymd').time(); // 'AS' by default taking for Aspire 
    	if(empty($loanAmount) || empty($loanTerm))
        {
            echo json_encode(array('statusCode' => '400','status'=>'Please enter loan amount and term')); exit;
        }
        else
        {  
        $data =[];
	    $data['loanAmount']             = $loanAmount;
	    $data['loanTerm']               = $loanTerm;
	    $data['tokenNumber']            = $loanToken;
	    $id     = DB::table('t_loan')->insertGetId($data);
	    $lastId = $id;
	    $loanRepayAmount  = $loanAmount / $loanTerm;
	    $curDate = date("Y-m-d");
	    $newCurrDate = $curDate;
	    $repayAmount = [];
        for($i=0; $i<$loanTerm; $i++) {
										
			$payDate = date('Y-m-d', strtotime($newCurrDate.' +7 days'));
			$repayAmount['loanId']= $lastId;
			$repayAmount['loanAmount']= $loanRepayAmount;
			$repayAmount['paymentDate']= $payDate;
			$newCurrDate = $payDate;
			DB::table('t_loan_payment')->insert($repayAmount);
			// print"<pre>";print_r($repayAmount);
			
		}
	    echo json_encode(array('statusCode' => '200','status' => 'Your loan created successfully and your loan number is '.$loanToken));
		}

    }
    function getAllLoans(){
    	$resData =[];
    	$allLoan = DB::table('t_loan')
                        ->selectRaw('intId,loanAmount,loanTerm,createdOn,tokenNumber,IF(loanStatus=1,"Approved","Pending") as loanStatus,IF(payStatus=1,"Paid","Pending") as paymentStaus')
                        ->get()->toArray();
                       // print_r($allLoan);
         $allLoan = json_decode(json_encode($allLoan),true);
         foreach ($allLoan as $key => $value) {
         	$resData[$key] = $value;
         	$allLoanRepay = DB::table('t_loan_payment')->where('loanId',$value['intId'])
                        ->selectRaw('loanAmount,IF(paymentStaus=1,"Paid","Pending") as paymentStaus,paymentDate,paidOn,paidAmount')
                        ->get()->toArray();
            $allLoanRepay = json_decode(json_encode($allLoanRepay),true);
 

            $resData[$key]['repayList'] = $allLoanRepay;

         }
        echo json_encode(array('statusCode' => '200','status'=>'Successful','loanList'=>$resData));
    }


    function takeAction(){
    	
    	$arrPageData=request()->all();
    	$tokenNumber = $arrPageData['loanToken'];
    	$loanStatus   = $arrPageData['status'];
    	$updated = DB::table('t_loan')->where('tokenNumber',$tokenNumber)->update(array('loanStatus' => $loanStatus)); 
      echo json_encode(array('statusCode' => '200','status'=>'Status updated successfully'));
    }

    function getOwnLoans(){

    	$arrData=request()->all();
    	$tokenNumber = $arrData['loanToken'];
    	$resData=[];
    	$ownLoan = DB::table('t_loan as L')
            ->leftJoin('t_loan_payment as LP', 'L.intId', '=', 'LP.loanId')
            ->select('LP.*', 'L.tokenNumber')->where('L.tokenNumber',$tokenNumber)
            ->get()->toArray();

            //print_r($ownLoan);exit;
        $ownLoan = json_decode(json_encode($ownLoan),true);

    	foreach ($ownLoan as $key => $value) {
    		$resData[$key]= $value;
    		$resData[$key]['needPay']= $value['loanAmount']-$value['paidAmount'];
    		if($value['paymentStaus']==1)
    		{
    			$resData[$key]['paymentStatus']= 'Paid';
    		}
    		else
    		{
    			$resData[$key]['paymentStatus']= 'Pending';
    		}
    	}
        echo json_encode(array('statusCode' => '200','status'=>'Successful','loanList'=>$resData));
    }



    function payLoanAmount(){

    	$arrData=request()->all();
    	$tokenNumber = $arrData['loanToken'];
    	$payLoanAmount = $arrData['loanAmount'];
    	$dueDate = !empty($arrData['dueDate'])?date('Y-m-d', strtotime($arrData['dueDate'])):"";
    	$payDate = date('Y-m-d H:i:s');
    	//dd($arrData);
    	if(empty($tokenNumber) || empty($payLoanAmount) || empty($dueDate))
        {
            echo json_encode(array('statusCode' => '400','status'=>'Please enter loan token number amount and due date'));exit;
        }
        else
        {

    	$ownLoan = DB::table('t_loan as L')
            ->leftJoin('t_loan_payment as LP', 'L.intId', '=', 'LP.loanId')
            ->select('LP.*', 'L.tokenNumber','L.intId','L.loanTerm')->where('L.tokenNumber',$tokenNumber)->where('LP.paymentDate',$dueDate)
            ->first();

          //print_r($ownLoan);exit;
           
           		$paymentDate = date('Y-m-d', strtotime($ownLoan->paymentDate));
           		$paymentStatus = $ownLoan->paymentStaus;
           		$loanId = $ownLoan->loanId;
           		$intId = $ownLoan->intId;
           		$loanAmount = $ownLoan->loanAmount;
           		$paidAmount = $ownLoan->paidAmount;
           		$loanTerm = $ownLoan->loanTerm;
           		if($paymentDate==$dueDate)
           		{
           			if($paymentStatus!=1)
           			{
           				if($payLoanAmount>=($loanAmount-$paidAmount))
           				{
           				$updateData = DB::table('t_loan_payment')->where('paymentDate',$dueDate)->where('loanId',$intId)->update(array('paymentStaus' => 1,'paidAmount' =>$loanAmount,'paidOn'=>$payDate));

           				$nextDueDate = date('Y-m-d', strtotime($dueDate.' +7 days'));
           				$extraAmount = $payLoanAmount-($loanAmount-$paidAmount);
           				// start extra pay amount settle for next payment schedule
           				$updateAmount = DB::table('t_loan_payment')->where('paymentDate',$nextDueDate)->where('loanId',$intId)->update(array('paidAmount' =>$extraAmount));
           				// end
           					
           					$loanPaidCount = DB::table('t_loan_payment')->where('loanId',$intId)->where('paymentStaus',1)->count();

           					if($loanPaidCount==$loanTerm)
           					{
           						$updateAmount = DB::table('t_loan')->where('tokenNumber',$tokenNumber)->update(array('payStatus' =>1));
           					}
           				echo json_encode(array('statusCode' => '200','status'=>'Your loan amount paid successfully'));

           			    }
           			    else
           			    {
           			    	echo json_encode(array('statusCode' => '404','status'=>'Your payment amount can not less than from actual loan amount'));
           			    }
           			}
           			else
           			{
           				echo json_encode(array('statusCode' => '404','status'=>'Your loan amount paid on this date'));
           			}
           		}
           		else
           		{
           			echo json_encode(array('statusCode' => '404','status'=>'Please enter valid loan due date'));
           		}
           		
        
    	}
    }
}