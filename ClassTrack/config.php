<?php
session_start();
// setting up the initial variables
$_SESSION['index_page'] = "./index.php";
$_SESSION['err_page'] = "./err_page.php";
$_SESSION['home_page'] = "./home.php";
$_SESSION['login_page'] = "./login.php";
$_SESSION['Info_Update_page'] = "./Info_Update_page.php";
$connect = pg_connect("host=localhost dbname=ClassTrackDB user=ClassTrack password=ClassTrack@123");
if (!$connect) {
    $_SESSION['err_message'] = "Connection to Database failed!!";
    $_SESSION['path'] = $_SESSION['login_page'];
    $_SESSION['button_val'] = "Try Again!!";
    $_SESSION['err_code'] = 501;
    header("Location: {$_SESSION['err_page']}");
    exit();
}
/*
Error Codes:-
Index page = 1
Login page = 2
Home page = 3
err_page = 4
Config page = 5
Info_Update page = 6

Database connection failed = 01
Unable to fetch/update user data = 02
Unable to fetch content data = 03
Login first = 04
File/path not found = 05
Logout Failed = 06
*/


/*
Postgres view and function queries:-
Tables:- 
Staffmember:-
    create table staffmember(uid varchar primary key,username text unique not null check(username like'%@%'),
    password text not null check(char_length(password)>8),role text not null check(role in('Admin','Teacher')),
    full_name text not null,date_of_birth date not null,address varchar not null,salary text not null,date_joined date not null,
    education varchar not null,gender text not null check(gender in('female','male','other')));


Views:-
Information:-
    create or replace view Information as 
    select uid,username,role,full_name,date_of_birth,address,salary,date_joined,education,gender from staffmember order by Uid;

Class:- (To get time till reamaining reservation time)
    create view class as SELECT c.classroom_id,cs.resv_end_time - CURRENT_TIME::time without time zone AS time_remainingFROM classroom c
    JOIN classroom_schedule cs ON c.classroom_id::text = cs.classroom_id::textWHERE cs.resv_date = CURRENT_DATE;
    ******endTime-currentTime************

Class_stat:-
    create or replace view class_stat as select * from classroom_schedule;

Class_schedule:- (To get classrom's schedule today)
    create view class_schedule as SELECT c.classroom_id,cs.username,cs.resv_date,cs.resv_start_time,cs.resv_end_time,cs.subjectFROM classroom c
    JOIN classroom_schedule cs ON c.classroom_id::text = cs.classroom_id::textWHERE cs.resv_date = CURRENT_DATE;

Function:-
Self:- (To get Personal Info)
    create function Self(uname text) returns setof Information as $Self$ 
    declare info Information%rowtype;
    begin 
    select * into info from Information where username=uname;
    if info is null then return query select -1;
    else return next info;
    end if;
    end;
    $Self$
    language 'plpgsql';

Logout:- (To logout)
    create or replace function logout(uname text)returns int as $lgout$declare f int;t timestamp;
    begin update log set logout_time=current_timestamp::timestamp where username=uname and logout_time is null; 
    select logout_time into t from log where username=uname and logout_time is null; if t is null then  return 1;else return -1;end if; end;
    $lgout$language 'plpgsql';

Auth:- (To authenticate)
    create function auth(uname text,passwd text)returns text as $auth$declare pwd text;r text;begin select password into pwd from staffmember where username=uname;
    if pwd=passwd then insert into log values(uname,current_timestamp::timestamp); select role into r from staffmember where username=uname;return r;else return -1;end if;end;
    $auth$lagnuage 'plpgsql';

Class_stat:- (To get classroom status)
    create or replace function class_stat(cid varchar)returns text as $class_stat$ declare status text;time interval;
    begin select time_remaining into time from class where classroom_id=cid;if time<='00:00:00'::time then select cid||' 1' into status;else select cid||' 0' into status;
    end if; return status;end;$class_stat$language'plpgsql';
    ********1 = Free now, 0 = occupied now*************

Class_sch:- (To get classroom)
    create function class_sch(cid varchar)returns setof class_schedule as$class_sch$ begin return query select * from class_schedule where classroom_id=cid;end; 
    $class_sch$ language 'plpgsql';
 */

 
