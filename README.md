When run this project first need to databse configuration.

1. Open database.php file from config folder and keep this below code.

'host' =>'127.0.0.1',
'port' => '3307',
'database' =>'loan',
'username' => 'root',
'password' => 'Admin@123',

In .env files configuration is not working for my system that`s why i am configuring to database.php files.

2. I have keep DB folder for database table configuration take this files from DB folder and import 
in your database.
3. I have also created for Postman folder for collection of all API. please take files from postman 
folder and import on your postman for checking the API functionlity.

REST API :-
1. Customer create loan
URL :- http://127.0.0.1:8000/api/request_loan (Keep it post method)
Request :-
{ 
   "loanAmount":"30000",
   "loanTerm":"3"
}
Response :-
{"statusCode":"200","status":"Your loan created successfully and your loan number is AS2208181660815346"}


2. Admin View All created loan by customer
URL :- http://127.0.0.1:8000/api/get_all_loans (Keep it get method)
Request :-

Response :-
{
    "statusCode": "200",
    "status": "Successful",
    "loanList": [
        {
            "intId": 1,
            "loanAmount": "15000.00",
            "loanTerm": 5,
            "createdOn": "2022-08-18 15:05:14",
            "tokenNumber": "AS2208181660815313",
            "loanStatus": "Pending",
            "paymentStaus": "Pending",
            "repayList": [
                {
                    "loanAmount": "3000.00",
                    "paymentStaus": "Pending",
                    "paymentDate": "2022-08-25 00:00:00",
                    "paidOn": null,
                    "paidAmount": "0.00"
                },
                {
                    "loanAmount": "3000.00",
                    "paymentStaus": "Pending",
                    "paymentDate": "2022-09-01 00:00:00",
                    "paidOn": null,
                    "paidAmount": "0.00"
                },
                {
                    "loanAmount": "3000.00",
                    "paymentStaus": "Pending",
                    "paymentDate": "2022-09-08 00:00:00",
                    "paidOn": null,
                    "paidAmount": "0.00"
                },
                {
                    "loanAmount": "3000.00",
                    "paymentStaus": "Pending",
                    "paymentDate": "2022-09-15 00:00:00",
                    "paidOn": null,
                    "paidAmount": "0.00"
                },
                {
                    "loanAmount": "3000.00",
                    "paymentStaus": "Pending",
                    "paymentDate": "2022-09-22 00:00:00",
                    "paidOn": null,
                    "paidAmount": "0.00"
                }
            ]
        },
        {
            "intId": 2,
            "loanAmount": "30000.00",
            "loanTerm": 3,
            "createdOn": "2022-08-18 15:05:46",
            "tokenNumber": "AS2208181660815346",
            "loanStatus": "Pending",
            "paymentStaus": "Pending",
            "repayList": [
                {
                    "loanAmount": "10000.00",
                    "paymentStaus": "Pending",
                    "paymentDate": "2022-08-25 00:00:00",
                    "paidOn": null,
                    "paidAmount": "0.00"
                },
                {
                    "loanAmount": "10000.00",
                    "paymentStaus": "Pending",
                    "paymentDate": "2022-09-01 00:00:00",
                    "paidOn": null,
                    "paidAmount": "0.00"
                },
                {
                    "loanAmount": "10000.00",
                    "paymentStaus": "Pending",
                    "paymentDate": "2022-09-08 00:00:00",
                    "paidOn": null,
                    "paidAmount": "0.00"
                }
            ]
        }
    ]
}

3. Admin take action on loan by putting loan token numebr and  1 in status for approval
URL :- http://127.0.0.1:8000/api/take_action (Keep it post method)
Request :-
{ 
   "loanToken":"AS2208181660815346",
   "status":"1"
}
Response :-
{"statusCode":"200","status":"Status updated successfully"}

4. Customer can view own loan status and payment resheduled date by providing token number.
URL :- http://127.0.0.1:8000/api/get_own_loans (Keep it post method)
Request :-
{ 
   "loanToken":"AS2208181660815346"
}
Response :-
{
    "statusCode": "200",
    "status": "Successful",
    "loanList": [
        {
            "intId": 6,
            "loanId": 2,
            "loanAmount": "10000.00",
            "paymentDate": "2022-08-25 00:00:00",
            "paymentStaus": 1,
            "paidAmount": "10000.00",
            "paidOn": "2022-08-18 09:39:58",
            "tokenNumber": "AS2208181660815346",
            "needPay": 0,
            "paymentStatus": "Paid"
        },
        {
            "intId": 7,
            "loanId": 2,
            "loanAmount": "10000.00",
            "paymentDate": "2022-09-01 00:00:00",
            "paymentStaus": 1,
            "paidAmount": "10000.00",
            "paidOn": "2022-08-18 09:40:36",
            "tokenNumber": "AS2208181660815346",
            "needPay": 0,
            "paymentStatus": "Paid"
        },
        {
            "intId": 8,
            "loanId": 2,
            "loanAmount": "10000.00",
            "paymentDate": "2022-09-08 00:00:00",
            "paymentStaus": 1,
            "paidAmount": "10000.00",
            "paidOn": "2022-08-18 09:40:41",
            "tokenNumber": "AS2208181660815346",
            "needPay": 0,
            "paymentStatus": "Paid"
        }
    ]
}

5. Customer can pay loan amount by providing token number, loan amount and due date
URL :- http://127.0.0.1:8000/api/payLoanAmount (Keep it post method)
Request :-
{ 
   "loanToken":"AS2208181660815346",
   "loanAmount":"10000",
   "dueDate":"08-09-2022"
}
Response :-
{"statusCode":"200","status":"Your loan amount paid successfully"}

