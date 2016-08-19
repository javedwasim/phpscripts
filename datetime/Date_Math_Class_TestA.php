<?php

/*
   	Copyright (C) 2014 Software Installation Services, Inc.
	Author: Bob Wedwick, Phoenix, AZ 602-449-8552 bob at wedwick dot com.

	This program is free software: you can redistribute it or modify it under the terms
	of the GNU General Public License as published by the Free Software Foundation,
	either version 3 of the License or any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	See http://www.gnu.org/licenses/licenses.en.html for a copy of the GNU General Public License.

	Use: php Date_Math_Class_TestA.php <test number> [test number]... [96] [97] [98] [99]

	This script performs tests for class Date_Math_ClassA.php
	and serves as examples of different ways to use functions included in this class.
	Designed and tested as a console application.

	Input date formats supported are:
		y-m-d, y/m/d, y.m.d, m-d-y, m/d/y, m.d.y
		where 'y' is 4 digits (leading zeros for years before 1000), 'm' and 'd' may be 1 or 2 digits.
		Also supported is ymd format which must be 8 digits: 4-digit year and 2-digit month and day.
		Null or blank input date formats revert to the default format.
		Upper case letters are converted to lower case for testing.

	Output date formats include: yyyy-mm-dd, yyyy.mm.dd, yyyy/mm/dd, mm/dd/yyyy, yyyymmdd
		With the first four formats, mm and dd do not require leading zeros. yyyymmdd must be 8 digits long.

	Dates can be converted from any format above to any other.

	Date range for this class is from the year 0032 A.D. to 9999 A.D.

	Command line arguments that change behaviors only for this test script:
		96 - Changes default format to y/m/d instead of y-m-d
		97 - Change start of week to Monday instead of Sunday
		98 - Toggles throwing exceptions
		99 - Toggles the use of time blocks

	When used with throwing exceptions, only first error encountered is shown.

	Example below is for using this test script when it is in the same directory as Date_Math_ClassA.php

	php Date_Math_Class_Test.php 1 2 98 1 2 99 1 2
	Runs test 1 and 2 then changes to throw exceptions,
		again runs 1 and 2, then changes to use time blocks
		then again runs 1 and 2

*/

	require_once "DateMathClassA.php";

################ require_once "<Path>Date_Math_ClassA.php";

	# initialize some good and some bad date values
	$aDate = '2011-5-26 12:34:56';
	$badDate = '2000-14-01';
	$badDate2 = '2000-Feb-01';
	$badDate3 = '20111301';

	# create the date math object
	$dt = new date_math_class;

	# set to not "throw -- catch" exceptions
	$dt->UseExceptions(false);

	# set to not use optional time blocks
	$dt->UseTimeBlocks(false);
	
	echo TestAddDays();
	
	# if no arguments
	if ($argc < 2) {

		# tell how to use this
		echo "Use: php Date_Math_Class_Test.php <test number 1-67> [test number]...\n"
			."96 to change default format\n97 to change start of the week\n"
			."98 to toggle using Exceptions\n99 to toggle using time blocks\n";
		# then exit
		exit;
	# ....
	}

	# if 1st argument is a test
	if ($argv[1] < 90) {

		# show the state of exceptions and time block
		ShowStates();
	# ....
	}

	# loop through arguments 1-n
	for ($i = 1; $i < $argc; $i++) {

		# get a test number from the agruments
		$testNumber = $argv[$i];

		# try
		try {
			switch ($testNumber) {
			case  1: TestAddDays(); break;
			case  2: TestAddMonths(); break;
			case  3: TestAddWeeks(); break;
			case  4: TestAddYears(); break;
			case  5: TestAgeInYears(); break;
			case  6: TestDateIsValid(); break;
			case  7: TestDateToJulian(); break;
			case  8: TestDayMonthYear(); break;
			case  9: TestDayOfTheMonth(); break;
			case 10: TestDayOfTheWeek(); break;
			case 11: TestDayOfTheYear(); break;
			case 12: TestDayOfTheYearToDate(); break;
			case 13: TestDifferenceInDays(); break;
			case 14: TestDifferenceInWeeks(); break;
			case 15: TestDifferenceInYears(); break;
			case 16: TestDowMonthDayYear(); break;
			case 17: TestEndOfNextMonth(); break;
			case 18: TestEndOfNextWeek(); break;
			case 19: TestEndOfNextYear(); break;
			case 20: TestEndOfPriorMonth(); break;
			case 21: TestEndOfPriorWeek(); break;
			case 22: TestEndOfPriorYear(); break;
			case 23: TestEndOfThisMonth(); break;
			case 24: TestEndOfThisWeek(); break;
			case 25: TestEndOfThisYear(); break;
			case 26: TestFirstOfGivenMonth(); break;
			case 27: TestFirstOfNextMonth(); break;
			case 28: TestFirstOfNextWeek(); break;
			case 29: TestFirstOfNextYear(); break;
			case 30: TestFirstOfPriorMonth(); break;
			case 31: TestFirstOfPriorWeek(); break;
			case 32: TestFirstOfPriorYear(); break;
			case 33: TestFirstOfThisMonth(); break;
			case 34: TestFirstOfThisWeek(); break;
			case 35: TestFirstOfThisYear(); break;
			case 36: TestGetLastError(); break;
			case 37: TestGreaterDate(); break;
			case 38: TestIsADate(); break;
			case 39: TestIsTheFirst(); break;
			case 40: TestJulianToDate(); break;
			case 41: TestLastDowForAMonth(); break;
			case 42: TestLesserDate(); break;
			case 43: TestMaximumDate(); break;
			case 44: TestMinimumDate(); break;
			case 45: TestMonthDayYear(); break;
			case 46: TestMonthNumber(); break;
			case 47: TestMonthStr(); break;
			case 48: TestNDaysBeforeEndOfTheMonth(); break;
			case 49: TestNextDayOfTheWeek(); break;
			case 50: TestNextFirstOfTheMonth(); break;
			case 51: TestNextFirstOfTheYear(); break;
			case 52: TestNextNthDayOfTheMonth(); break;
			case 53: TestNextNthOfTheMonth(); break;
			case 54: TestNthOfTheMonth(); break;
			case 55: TestNumberOfDaysInAMonth(); break;
			case 56: TestNumericDayOfTheWeek(); break;
			case 57: TestNumericMonth(); break;
			case 58: TestNumericYear() ; break;
			case 59: TestPriorDayOfTheWeek(); break;
			case 60: TestSubtractDays(); break;
			case 61: TestSubtractMonths(); break;
			case 62: TestSubtractWeeks(); break;
			case 63: TestSubtractYears(); break;
			case 64: TestWeekNumber(); break;
			case 65: TestYmd(); break;
			case 66: TestYmdArrayToDate(); break;
			case 67: TestYmdStringToDate(); break;


			case 96: ChangeDefaultFormat(); break;
			case 97: ChangeStartOfWeek(); break;
			case 98: ToggleExceptions(); break;
			case 99: ToggleUseTime(); break;

			# ....
			}

		# when any exception is caught
		} catch (Exception $e) {
			# echo the exception error message
			echo "Caught exception: {$e->getMessage()} \n";
    		# end exception
		}
	# <---
	}

# end main

### change default format
function ChangeDefaultFormat() {
	global $dt;

	# show test title
	EchoTitle("Change Default format to y/m/d");

	$dt->defaultFormat = "y/m/d";

# end function
}

### change start of week to be Monday
function ChangeStartOfWeek() {
	global $dt;

	# show test title
	EchoTitle("Start The Week On Monday");

	# Feb 2, 1942 was a Monday
	$dt->baseDate = '1942-02-02';

	# array of day-of-week abbreviations all upper case
	$dt->dayArray = array('MON','TUE','WED','THU','FRI','SAT','SUN');

	# rerun construct for the class
	$dt->__construct();

# end function
}

### echo a message
function EchoMsg($msg = 'unknown') {

	# echo a message only
	echo "$msg\n";

# end function
}

### echo a test result
function EchoResult($msg= 'No Msg', $result = null) {
	global $dt;

	# if result was boolean false
	if ($result === false) {

		# get and show last error
		$result = 'ERR: ' .$dt->GetLastError();

	# elseif result is boolean true
	} elseif ($result === true) {

		# show message and true result
		$result = '=== true';

	# elseif result is not null
	} elseif ($result !== null) {

		# add => ahead of the result
		$result = "=> $result";
	# ....
	}

	# echo the message and result
	echo "$msg $result\n";

# end function
}

### echo the title of a test
function EchoTitle($title = 'unknown') {

	# echo a message only
	EchoResult("\n<----- Testing $title ----->");

# end function
}

### show states of testing environment
function ShowStates() {
	global $dt;

	# when using exceptions
	$ex = ($dt->UseExceptions() )
		? 'USING'
		# insert the word NOT
		: 'NOT using';

	# when using time blocks
	$tb = ($dt->UseTimeBlocks() )
		? 'USING'
		# insert the word NOT
		: 'NOT using' ;

	# build the message
	$states = "$ex exceptions, $tb time blocks";

	# show the testing program's state string
	EchoTitle("$states");

# end function
}
### Add Days
function TestAddDays() {
	global $dt, $aDate, $badDate3;

	# show test title
	EchoTitle("Add Days");

	# Add 10 days to now and get new date saved to a variable
	$res = $dt->AddDays(10);
	EchoResult("Add 10 days to now", $res);

	# from here on, result is part of response being echoed.
	EchoResult("Add '0' days to 2012-03-24", $dt->AddDays('0','2012-03-24'));
	EchoResult("Add 9 days to leap year 2012-02-24", $dt->AddDays(9,'2012-02-24'));
	EchoResult("Add 9 days to 20110224 as mdy", 	$dt->AddDays(9,'20110224', 'mdy'));
	EchoResult("Add '-9' days to 2011-03-01", $dt->AddDays('-9','2011-03-01'));
	EchoResult("Add -9 days in a leap year to 2012-03-01", $dt->AddDays(-9,'2012-03-01'));
	EchoResult("Add 1 day to 1900-02-28", $dt->AddDays(1,'1900-02-28'));

	# if using time blocks
	if ($dt->UseTimeBlocks()) {

		EchoResult("Add 15 days to 2011-02-24 12:34:56 PM as m/d/y",
			$dt->AddDays('15','2011-02-24 12:34:56 PM', 'm/d/y'));
		EchoResult("add 9 days to 2011-02-24 1:2:00 AM as m/d/y",
			$dt->AddDays(9,'2011-02-24 1:2:00 AM', 'm/d/y'));
		EchoResult("add 9 days to 2011-02-24 01:02:00 as dmy",
			$dt->AddDays(9,'2011-02-24  01:02:00 ', 'dmy'));
		EchoResult("Add 19 days to 20110224 ", $dt->AddDays(19,'20110224'));
		EchoResult("Add '+19' days to 3088-02-25 8:10:12",
			$dt->AddDays('+19','3088-02-25 8:10:12'));
	# else
	} else {
		EchoResult("Add 15 days to 2011-02-24 as m/d/y",
			$dt->AddDays('15','2011-02-24', 'm/d/y'));

		EchoResult("add 9 days to 2011-02-24 as m/d/y",
			$dt->AddDays(9,'2011-02-24', 'm/d/y'));
		EchoResult("add 9 days to 2011-02-24 as dmy",
			$dt->AddDays(9,'2011-02-24 ', 'dmy'));

		EchoResult("Add 19 days to 20110224 ", $dt->AddDays(19,'20110224'));
		EchoResult("Add '+19' days to 3088-02-25",
			$dt->AddDays('+19','3088-02-25'));
	# ....
	}

	# ..... Show ERRORS
	EchoMsg("..... Show ERRORS .....");
	EchoResult("2011-13-01", $dt->AddDays(19,'2011-13-01'));
	EchoResult("19.2 days", $dt->AddDays(19.2,'2011-13-01'));
	EchoResult("2011-11-32", $dt->AddDays(19,'2011-11-32'));
	EchoResult("0011-11-03", $dt->AddDays(19,'0011-11-03'));
	EchoResult("2011-02-29", $dt->AddDays(19,'2011-02-29'));
	EchoResult("$badDate3", $dt->AddDays(19,$badDate3));
	EchoResult($aDate, $dt->AddDays('two',$aDate));

# end function
}

### Add Months
function TestAddMonths() {
	global $dt, $aDate,$badDate,$badDate3;

	# show test title
	EchoTitle("Add Months");

	# add 1 month and change format
	EchoResult("Add '+1' month in leap year to 2012-01-31 05:10 as m-d-y",
		$dt->AddMonths('+1','2012-01-31 05:10', 'm-d-y'));
	EchoResult("Add 12 months to 2011-01-31 4:45:00 AM as m/d/y",
		$dt->AddMonths(12,'2011-01-31 4:45:00 AM', 'm/d/y'));
	EchoResult("Add 1 month to 2011-01-31 4:46:00 AM as m/d/y",
		$dt->AddMonths(1,'2011-01-31 4:46:00 AM', 'm/d/y'));
	EchoResult("Add -1 month to 2011-01-31 4:47:00 AM as m/d/y",
		$dt->AddMonths(-1,'2011-01-31 4:47:00 AM', 'm/d/y'));
	EchoResult("Add 21 months to 2012-01-31", $dt->AddMonths(21,'2012-01-31'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("$badDate", $dt->AddMonths(21,$badDate));
	EchoResult("Invalid months", $dt->AddMonths('ten',$aDate));
	EchoResult("$badDate3", $dt->AddMonths(19,$badDate3));

# end function
}

### Add Weeks
function TestAddWeeks() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Add Weeks");

	# add 1 week to a leap year day
	EchoResult("Add 1 week to 2012-02-29 4:03:05 AM as m-d-y",
		$dt->AddWeeks(1,'2012-02-29 4:03:05 AM','m-d-y'));
	EchoResult("Add 1 week to 2011-02-23 4:13:05 PM as m-d-y",
		$dt->AddWeeks(1,'2011-02-23 4:13:05 PM','m-d-y'));
	# add 1 week to a leap year day
	EchoResult("Add -1 week to 2012-02-29 4:23:05 as y/m/d",
		$dt->AddWeeks(-1,'2012-02-29 4:23:05','y/m/d'));
	EchoResult("Add '13' weeks to 2012-01-31", $dt->AddWeeks('13','2012-01-31'));
	EchoResult("Add 14 weeks to 20120131", $dt->AddWeeks(14, 20120131));
	EchoResult("Add '002' weeks to now", $dt->AddWeeks('002',null));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("$badDate", $dt->AddWeeks(21, $badDate));
	EchoResult("$aDate", $dt->AddWeeks('six6',$aDate));
	EchoResult("$badDate3", $dt->AddWeeks(9, $badDate3));
	EchoResult("Add 1 week to 2011-02-29", $dt->AddWeeks(1,'2011-02-29','m-d-y'));

# end function
}

### Add Years
function TestAddYears() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Add Years");

	# add 1 year to a leap year day
	EchoResult("Add 1 year in leap year to 02-29-2012 5:6:7 as m/d/y",
		$dt->AddYears(1,'02-29-2012 5:6:7', 'm/d/y'));
	EchoResult("Add 1 year to 02-28-2011 as m/d/y",
		$dt->AddYears(1,'02-28-2011', 'm/d/y'));

	# add -2 years to a leap year day
	EchoResult("Add -2 years to 02-29-2012 1:02:03 PM as m/d/y",
		$dt->AddYears(-2,'02-29-2012 1:02:03 PM', 'm/d/y'));

	# add 28 years
	EchoResult("Add 28 years to leap year 2012.02.29 08:00",
		$dt->AddYears(28,'2012.02.29 08:00'));

	# add 31 years
	EchoResult("Add '31' years to leap year 2012-02-29 2:3:4 AM",
		$dt->AddYears('31','2012-02-29 2:3:4 AM'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->AddYears(21,$badDate));
	EchoResult("20111301", $dt->AddYears('9',20111301));
	EchoResult($aDate, $dt->AddYears('two',$aDate));

# end function
}

### Absolute age In Years.
function TestAgeInYears() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Age In Years");

	$a = '2002-01-04';
	$b = '2013-1-4';
	$c = 20130103;

	# age from a date to now
	EchoResult("Age between $a and now", $dt->AgeInYears($a));

	# age between two dates
	EchoResult("Age between $a and $b ",$dt->AgeInYears($a, $b));
	EchoResult("Age between $a and $c",	$dt->AgeInYears($a, $c));

	# age between two dates with 1st being later
	EchoResult("Age between $c and $a",$dt->AgeInYears($c,$a ));
	EchoResult("Age between $aDate and $a", $dt->AgeInYears($aDate, $a ));

	# if using time blocks
	if ($dt->UseTimeBlocks()) {
		EchoMsg(".....  When time may change the result.");

		# test ages between two dates when time makes a difference
		$a = '2000-01-03 12:59';
		$b = '2013-01-03 13:00';
		$c = '2000-01-03 13:00';
		$d = '2013-01-03 12:59';

		EchoResult("Age between $a and $b" ,$dt->AgeInYears($a,$b));
		EchoResult("Age between $c and $b", $dt->AgeInYears($c,$b ));
		EchoResult("Age between $c and $d", $dt->AgeInYears($c,$d ));
	# ....
	}

	EchoMsg("..... Show ERRORS .....");
	EchoResult("$badDate and 2002-01-04", $dt->AgeInYears($badDate,'2002-01-04'));

	EchoResult("2002-01-04 and $badDate", $dt->AgeInYears('2002-01-04', $badDate));
	EchoResult("$badDate3", $dt->AgeInYears($badDate3));

# end function
}

### Date Is Valid. A null or blank date defaults to now.
function TestDateIsValid() {
	global $dt, $aDate, $badDate, $badDate2,$badDate3;

	# show test title
	EchoTitle("Date Is Valid");

	EchoResult("Valid date null", $dt->DateIsValid(null));
	EchoResult("Valid date blank", $dt->DateIsValid(' '));

	EchoResult("Valid date 2000-1-01 as y/m/d", $dt->DateIsValid('2000-1-01', 'y/m/d'));
	EchoResult("Valid date 11/01/2000", $dt->DateIsValid('11/01/2000'));
	EchoResult("Valid date 20020103", $dt->DateIsValid('20020103'));
	EchoResult("Valid date 2003.01.4 09:10:11 as m-d-y",
		$dt->DateIsValid('2003.01.4 09:10:11', 'm-d-y'));
	EchoResult("Valid date 2003/01/04 default format", $dt->DateIsValid('2003/01/04'));
	EchoResult("Valid date 2010-04-15 10:04:15", $dt->DateIsValid('2010-04-15 10:04:15'));
	EchoResult("Valid date $aDate", $dt->DateIsValid($aDate));

	EchoMsg("..... Show ERRORS .....");
	# 1900 was not a leap year
	EchoResult("1900-02-29 1900 was not a leap year", $dt->DateIsValid('1900-02-29'));

	# when invalid dates are sent
	EchoResult($badDate, $dt->DateIsValid($badDate));
	EchoResult($x = "2011-3-32", $dt->DateIsValid($x));
	EchoResult($x = "32/3/2011", $dt->DateIsValid($x));
	EchoResult($x ="20x0-1-2", $dt->DateIsValid($x));
	EchoResult($x ="abcd", $dt->DateIsValid($x));
	EchoResult($badDate2, $dt->DateIsValid($badDate2));
	EchoResult($badDate3, $dt->DateIsValid($badDate3));

# end function
}

### Date To Julian - return an integer - no fractions.
function TestDateToJulian() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Date To Julian");

	EchoResult("Julian date for $aDate" , $dt->DateToJulian($aDate));
	EchoResult("**** PHP Julian allows for 1900-02-29 when 1900 is not a leap year");
	EchoResult("Julian date for 19000228" , $dt->DateToJulian(19000228));
	EchoResult("Julian date for 19000301" , $dt->DateToJulian(19000301));
	EchoResult("Julian date for now" , $dt->DateToJulian());
	EchoResult('Julian date for ' .$a = '2012-01-01 1:2 pm' , $dt->DateToJulian($a));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->DateToJulian($badDate));
	EchoResult($badDate3, $dt->DateToJulian($badDate3));

# end function
}

### day Month Year - return a date formatted as day month year
function TestDayMonthYear() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Day Month Year");
	EchoResult("Day month year for now", $dt->DayMonthYear());
	EchoResult("Day month year for $aDate", $dt->DayMonthYear($aDate));
	EchoResult("Day month year for " .$a = "2012-01-1 1:2 pm" , $dt->DayMonthYear($a));
	EchoResult("Day month year for " .$a ="01/19/2012" , $dt->DayMonthYear($a));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->DayMonthYear($badDate));
	EchoResult($badDate3, $dt->DayMonthYear($badDate3));

# end function
}

### Day Of The Month. Returns numeric day of month
function TestDayOfTheMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Day Of The Month");
	EchoResult("Day of month for now", $dt->DayOfTheMonth());
	EchoResult("Day of month for $aDate", $dt->DayOfTheMonth($aDate));
	EchoResult("Day of month for " .$a="2012-01-1 1:2 pm" , $dt->DayOfTheMonth($a));
	EchoResult("Day of month for " .$a="01/19/2012" , $dt->DayOfTheMonth($a));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->DayOfTheMonth($badDate));
	EchoResult($badDate3, $dt->DayOfTheMonth($badDate3));

# end function
}

### Day Of The Week
function TestDayOfTheWeek() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Day Of The Week");
	EchoResult("Day of week for " .$a= "2012-1-1" , $dt->DayOfTheWeek($a));
	EchoResult("Day of week for " .$a= "2012-01-01 1:2 pm" , $dt->DayOfTheWeek($a));
	EchoResult("Day of week for $aDate" , $dt->DayOfTheWeek($aDate));
	EchoResult("Day of week for now" , $dt->DayOfTheWeek());
	EchoResult("Day of week for " .$a="01/19/2012" , $dt->DayOfTheWeek($a));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->DayOfTheWeek($badDate));
	EchoResult($badDate3, $dt->DayOfTheWeek($badDate3));

# end function
}

### Day Of The Year
function TestDayOfTheYear() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Day Of The Year");

	EchoResult("Day of year for " .$a="2012-01-2" , $dt->DayOfTheYear($a));
	EchoResult("Day of year for " .$a="2012-12-31 8:9:0" , $dt->DayOfTheYear($a));
	EchoResult("Day of year for " .$a="2011-12-31" , $dt->DayOfTheYear($a));
	EchoResult("Day of year for $aDate" , $dt->DayOfTheYear($aDate));
	EchoResult("Day of year for now" , $dt->DayOfTheYear());
	EchoResult("Day of year for " .$a="2011/10/13" , $dt->DayOfTheYear($a));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->DayOfTheYear($badDate));
	EchoResult($badDate3, $dt->DayOfTheYear($badDate3));

# end function
}

### day of the year to date
function TestDayOfTheYearToDate() {
	global $dt;

	# day of the year must be 1-366
	# year must be 32 -9999

	# show test title
	EchoTitle("Day Of The Year To Date");
	EchoResult("Day 57 of 1930", $dt->DayOfTheYearToDate(57,1930));
	EchoResult("Day 67 of 1930 as m/d/y", $dt->DayOfTheYearToDate(67,1930, 'm/d/y'));
	EchoResult("Day 67 of 1932 as m/d/y", $dt->DayOfTheYearToDate(67,1932, 'm/d/y'));
	EchoResult("Day '57' of '3030' ", $dt->DayOfTheYearToDate('57','3030'));
	EchoResult("Day 366 of leap year ", $dt->DayOfTheYearToDate('366','2008'));
	EchoResult("Day 123 of current year as m-d-y", $dt->DayOfTheYearToDate('123',null, 'm-d-y'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult("Day 0 ", $dt->DayOfTheYearToDate('0','1930'));
	EchoResult("Year 13 ", $dt->DayOfTheYearToDate('57','13'));
	EchoResult("366 days for non-leap year ", $dt->DayOfTheYearToDate('366','2003'));

# end function
}

### Difference In Days
function TestDifferenceInDays() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Difference In Days");

	# How many days is it between a date and now
	EchoResult("Difference in days between $aDate and now",
		$dt->DifferenceInDays($aDate));

	EchoResult("Difference in days between 2012-05-23 and now",
		$dt->DifferenceInDays('2012-05-23'));

	# How many days between two dates in a leap year
	EchoResult("Difference in days in leap year between 2012-02-23 and 2012-03-09",
		$dt->DifferenceInDays('2012-02-23','2012-03-09'));

	# How many days between two dates in a non-leap year
	EchoResult("Difference in days between 02/23/2011 and 2011-03-09",
		$dt->DifferenceInDays('02/23/2011','2011-03-09'));

	EchoResult("Difference in same day between 02/23/2011 and 02/23/2011 ",
		$dt->DifferenceInDays('02/23/2011','02/23/2011'));

	EchoResult("Difference in days between 02/24/2011 and 02/23/2011",
		$dt->DifferenceInDays('02/24/2011','02/23/2011'));

	# How many days between two dates (negative)
	EchoResult("Difference in days between 2012.03.23 and 2012-02-09",
		$dt->DifferenceInDays('2012.03.23','2012-02-09'));

	# dates where time makes a difference
	if ($dt->UseTimeBlocks()) {

		EchoMsg(".....  When time may change the result.");

		EchoResult("Difference in days between 02/23/2011 12:34 and 02/24/2011 01:23",
			$dt->DifferenceInDays('02/23/2011 12:34','02/24/2011 01:23'));
		EchoResult("Difference in days between 02/23/2011 01:23 and 02/24/2011 12:34",
			$dt->DifferenceInDays('02/23/2011 2:34','02/24/2011 11:23'));
	# ....
	}

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->DifferenceInDays($badDate));
	EchoResult($badDate3, $dt->DifferenceInDays($badDate3));

# end function
}

### Difference In Weeks
function TestDifferenceInWeeks() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Difference In Weeks");
	EchoResult("$aDate vs now", $dt->DifferenceInWeeks($aDate));

	EchoResult("now vs $aDate", $dt->DifferenceInWeeks(null,$aDate));
	$a = '1/4/2001';
	$b = '1/1/2000';
	$c = '1/1/2001';
	EchoResult("$b vs now", $dt->DifferenceInWeeks($b));
	EchoResult("$b vs $a", $dt->DifferenceInWeeks("$b", $a));
	EchoResult("$b vs 1-8-2001", $dt->DifferenceInWeeks($b, '1-8-2001'));

	EchoResult("$a vs $b", $dt->DifferenceInWeeks($a, $b));
	EchoResult("1/8/2001 vs $b", $dt->DifferenceInWeeks('1/8/2001', $b));
	EchoResult("$c vs 1/7/2001", $dt->DifferenceInWeeks($c, '1/7/2001'));
	EchoResult("$c vs 1/10/2001", $dt->DifferenceInWeeks($c, '1/10/2001'));
	EchoResult($a="1/10/2000" ." vs $b"  , $dt->DifferenceInWeeks($a ,$b));

	# dates where time makes a difference
	if ($dt->UseTimeBlocks()) {

		EchoMsg(".....  When time may change the result.");
		EchoResult("1/2/2014 14:00 vs 1-9-2014 04:00",
			$dt->DifferenceInWeeks('1/2/2014 14:00', '1-9-2014 4:00'));
		EchoResult("1/2/2014 04:00 vs 1-9-2014 14:00",
			$dt->DifferenceInWeeks('1/2/2014 14:00', '1-9-2014 14:00'));

	# ....
	}

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("$badDate vs $aDate", $dt->DifferenceInWeeks($badDate, $aDate));
	EchoResult("$aDate vs $badDate", $dt->DifferenceInWeeks($aDate, $badDate));
	EchoResult("$aDate vs $badDate3", $dt->DifferenceInWeeks($aDate, $badDate3));

# end function
}

### DifferenceInYears
function TestDifferenceInYears() {
	global $dt, $aDate, $badDate, $badDate3;

	# show test title
	EchoTitle("Difference In Years");
	EchoResult("$aDate vs now", $dt->DifferenceInYears($aDate));

	EchoResult("now vs $aDate", $dt->DifferenceInYears(null,$aDate));
	EchoResult("1/1/2000 vs now", $dt->DifferenceInYears('1/1/2000'));

	EchoResult("1/1/2000 vs 2001/1/2", $dt->DifferenceInYears('1/1/2000', '2001/1/2'));
	EchoResult("1/1/2000 vs 1/1/2001", $dt->DifferenceInYears('1/1/2000', '1/1/2001'));
	EchoResult("1/2/2000 vs 1/1/2001", $dt->DifferenceInYears('1/2/2000', '1/1/2001'));
	EchoResult("1/1/2000 vs 12/31/2000", $dt->DifferenceInYears('1/1/2000', '12/31/2000'));

	EchoResult("1/1/2001 vs 1.2.2000", $dt->DifferenceInYears('1/1/2001', '1.2.2000'));
	EchoResult("1/2/2001 vs 1/1/2000", $dt->DifferenceInYears('1/2/2001', '1/1/2000'));
	EchoResult("2001-1-1 vs 1/1/2000", $dt->DifferenceInYears('2001-1-1', '1/1/2000'));

	# note how years are determined with the second date being in a leap year
	EchoResult("2001-3-1 vs 2/29/2008", $dt->DifferenceInYears('2001/3/1', '2/29/2008'));
	EchoResult("2001-3-1 vs 3/1/2008", $dt->DifferenceInYears('2001/3/1', '3/1/2008'));

	# dates where time makes a difference
	if ($dt->UseTimeBlocks()) {
		EchoMsg(".....  When time may change the result.");
		EchoResult("2000/4/1 12:59 vs 2001/4/1 13:00 (1)",
			$dt->DifferenceInYears('2000/4/1 12:00','2001/4/1 13:00'));
		EchoResult("2000/4/1 13:00 vs 2001/4/1 12:59 (0)",
			$dt->DifferenceInYears('2000/4/1 13:00','2001/4/1 12:59'));
		EchoResult("2003-4-1 13:00 vs 2000/4/1 12:00 (-3)",
			$dt->DifferenceInYears('2003-4-1 13:00','2000/4/1 12:00'));
		EchoResult("2003-4-1 12:00 vs 2000/4/1 13:00 (-2)",
			$dt->DifferenceInYears('2003-4-1 12:00','2000/4/1 13:00'));
		EchoResult("2000-2-28 12:00 vs 2004/2/28 13:00 (4)",
			$dt->DifferenceInYears('2000-2-28 12:00','2004/2/28 13:00'));
		EchoResult("2000-2-28 13:00 vs 2004/2/28 12:00 (3)",
			$dt->DifferenceInYears('2000-2-28 13:00','2004/2/28 12:00'));
		EchoResult("2001-2-28 12:00 vs 2000/2/28 13:00 (0)",
			$dt->DifferenceInYears('2001-2-28 12:00','2000/2/28 13:00'));
	# ....
	}

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .......");
	EchoResult($badDate, $dt->DifferenceInYears($badDate));
	EchoResult($badDate3, $dt->DifferenceInYears($badDate3));

# end function
}

### Dow Month Day, Year
function TestDowMonthDayYear($date=null) {
 	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Day of week (Dow) Month Day, Year");
	EchoResult("Dow Month Day Year for now", $dt->DowMonthDayYear());
	EchoResult("Dow Month Day Year for $aDate", $dt->DowMonthDayYear($aDate));
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->DowMonthDayYear($badDate));
	EchoResult($badDate3, $dt->DowMonthDayYear($badDate3));

# end function
}

### End of the Next Month for a given date
function TestEndOfNextMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("End Of Next Month");
	EchoResult("End of next month from now as mdy", $dt->EndOfNextMonth(null,'mdy'));
	EchoResult("End of next month from $aDate", $dt->EndOfNextMonth($aDate));
	EchoResult("End of next month from 2012-01-31 00:00", $dt->EndOfNextMonth('2012-01-31 00:00'));
	EchoResult("End of next month from 2011-01-28", $dt->EndOfNextMonth('2011-01-28'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfNextMonth($badDate));
	EchoResult($badDate3, $dt->EndOfNextMonth($badDate3));

# end function
}

###	End of the Next Week for a given date
function TestEndOfNextWeek() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("End Of Next Week");
	EchoResult("End of next Week from now as mdy", $dt->EndOfNextWeek(null,'mdy'));
	EchoResult("End of next Week from $aDate", $dt->EndOfNextWeek($aDate));
	EchoResult("End of next Week from 2012-01-31", $dt->EndOfNextWeek('2012-01-31'));
	EchoResult("End of next Week from 2011-01-28", $dt->EndOfNextWeek('2011-01-28'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfNextWeek($badDate));
	EchoResult($badDate3, $dt->EndOfNextWeek($badDate3));

# end function
}

###	End of the Next Year  for a given date
function TestEndOfNextYear() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("End Of Next Year");
	EchoResult("End of next Year from now as mdy", $dt->EndOfNextYear(null,'mdy'));
	EchoResult("End of next Year from $aDate", $dt->EndOfNextYear($aDate));
	EchoResult("End of next Year from 2012-01-31", $dt->EndOfNextYear('2012-01-31'));
	EchoResult("End of next Year from 2011-01-28 23:59", $dt->EndOfNextYear('2011-01-28 23:59'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfNextYear($badDate));
	EchoResult($badDate3, $dt->EndOfNextYear($badDate3));

# end function
}

### End of the Prior Month for a given date
function TestEndOfPriorMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("End Of Prior Month for a given date");
	EchoResult("End of prior month from now as mdy", $dt->EndOfPriorMonth(null,'mdy'));
	EchoResult("End of prior month from $aDate", $dt->EndOfPriorMonth($aDate));
	EchoResult("End of prior month from 2012-03-31 13:22", $dt->EndOfPriorMonth('2012-03-31 13:22'));
	EchoResult("End of prior month from 2011-02-28", $dt->EndOfPriorMonth('2011-02-28'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfPriorMonth($badDate));
	EchoResult($badDate3, $dt->EndOfPriorMonth($badDate3));

# end function
}

### End of the Prior Week for a given date
function TestEndOfPriorWeek() {

	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("End Of Prior Week for a given date");
	EchoResult("End of prior Week from now as mdy", $dt->EndOfPriorWeek(null,'mdy'));
	EchoResult("End of prior Week from $aDate", $dt->EndOfPriorWeek($aDate));
	EchoResult("End of prior Week from 2012-03-31", $dt->EndOfPriorWeek('2012-03-31'));
	EchoResult("End of prior Week from 2011-02-28", $dt->EndOfPriorWeek('2011-02-28'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfPriorWeek($badDate));
	EchoResult($badDate3, $dt->EndOfPriorWeek($badDate3));

# end function
}

### End of the Prior Year for a given date
function TestEndOfPriorYear() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("End Of Prior Year for a given date");
	EchoResult("End of prior Year from now (null) as mdy", $dt->EndOfPriorYear(null,'mdy'));
	EchoResult("End of prior Year from blank ", $dt->EndOfPriorYear(''));
	EchoResult("End of prior Year from $aDate", $dt->EndOfPriorYear($aDate));
	EchoResult("End of prior Year from 2011-02-28", $dt->EndOfPriorYear('2011-02-28'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfPriorYear($badDate));
	EchoResult($badDate3, $dt->EndOfPriorYear($badDate3));

# end function
}

### End of the Month for a given date
function TestEndOfThisMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("End Of the Month for a given date");
	EchoResult("End of month for now", $dt->EndOfThisMonth());
	EchoResult("End of month for $aDate", $dt->EndOfThisMonth($aDate));
	EchoResult("End of month for 1942-07-08", $dt->EndOfThisMonth('1942-07-08'));
	EchoResult("End of month for 19580908", $dt->EndOfThisMonth(19580908));
	EchoResult("End of month for leap month 2004-02-08", $dt->EndOfThisMonth('2004-02-08'));
	EchoResult("End of month for 2003-2-8", $dt->EndOfThisMonth('2003-2-8'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfThisMonth($badDate));
	EchoResult($badDate3, $dt->EndOfThisMonth($badDate3));

# end function
}

### End of the Week for a given date
function TestEndOfThisWeek(){
	global $dt, $aDate, $badDate,$badDate3;

	EchoTitle("End Of This Week");
	EchoResult("End Of Week for $aDate as mdy", $dt->EndOfThisWeek($aDate,'mdy'));
	EchoResult("End Of Week for now", $dt->EndOfThisWeek(null));
	EchoResult("End Of Week for 2014-02-25", $dt->EndOfThisWeek('2014-02-25'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfThisWeek($badDate));
	EchoResult($badDate3, $dt->EndOfThisWeek($badDate3));

# end function
}

### End Of the Year  for a given date
function TestEndOfThisYear(){
	global $dt, $aDate, $badDate,$badDate3;

	EchoTitle("End Of This Year");
	EchoResult("End Of Year for $aDate as mdy", $dt->EndOfThisYear($aDate,'mdy'));
	EchoResult("End Of Year for now", $dt->EndOfThisYear(null));
	EchoResult("End Of Year for 2014-02-25", $dt->EndOfThisYear('2014-02-25'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->EndOfThisYear($badDate));
	EchoResult($badDate3, $dt->EndOfThisYear($badDate3));

# end function
}

### First Of Given Month - return a formatted string for the next first of the month for the 3-char month passed
function TestFirstOfGivenMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("First Of Given Month");
	EchoResult("First of December after now", $dt->FirstOfGivenMonth('december'));
	EchoResult("First of October after now as y/m/d", $dt->FirstOfGivenMonth('octob','','y/m/d'));
	EchoResult("First of Feb after 2012-09-01", $dt->FirstOfGivenMonth('Feb','2012-09-01'));
	EchoResult("First of April after 2012-09-01 as m/d/y", $dt->FirstOfGivenMonth('April','2012-09-01', 'm/d/y'));
	EchoResult("First of Sept after 2012-09-01 as m/d/y", $dt->FirstOfGivenMonth('Sept','2012-09-01', 'm/d/y'));

	# when an invalid data is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfGivenMonth('JAN',$badDate));
	EchoResult('Bad month JJJ', $dt->FirstOfGivenMonth('JJJ','2012-09-01'));

# end function
}

### First Of Next Month for a given date
function TestFirstOfNextMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("First Of Next Month for a given date");
	EchoResult("Future first of month after now", $dt->FirstOfNextMonth());
	EchoResult("Future first of month after $aDate", $dt->FirstOfNextMonth($aDate));
	EchoResult("Future first of month after 2014-3-1 13:45:22", $dt->FirstOfNextMonth('2014-3-1 13:45:22'));
	EchoResult("Future first of month after leap month 2004-02-29 12:12:12 PM",
		$dt->FirstOfNextMonth('2004-02-29 12:12:12 PM', 'm/d/y'));
	EchoResult("Future first of next month after 2003-02-08",
		$dt->FirstOfNextMonth('2003-02-08','ymd'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfNextMonth($badDate));
	EchoResult($badDate3, $dt->FirstOfNextMonth($badDate3));

# end function
}

### First of Next Week for a given date
function TestFirstOfNextWeek() {
	global $dt, $aDate, $badDate,$badDate3;

	EchoTitle("First of Next Week for a given date");
	EchoResult("First of Next Week after now", $dt->FirstOfNextWeek());
	EchoResult("First of Next Week after $aDate", $dt->FirstOfNextWeek($aDate));
	EchoResult("First of Next Week after 1942-07-08", $dt->FirstOfNextWeek('1942-07-08'));
	EchoResult("First of Next Week after 2004-02-29", $dt->FirstOfNextWeek('2004-02-29'));
	EchoResult("First of Next Week after 2014-02-9 07:08", $dt->FirstOfNextWeek('2014-02-9 07:08'));
	EchoResult("First of Next Week after 2003-03-08", $dt->FirstOfNextWeek('2003-03-08','y.m.d'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfNextWeek($badDate));
	EchoResult($badDate3, $dt->FirstOfNextWeek($badDate3));

# end function
}

### First of Next Year for a given date
function TestFirstOfNextYear() {
	global $dt, $aDate, $badDate,$badDate3;

	EchoTitle("First of Next Year for a given date");
	EchoResult("First of Next Year after now", $dt->FirstOfNextYear());
	EchoResult("First of Next Year after $aDate", $dt->FirstOfNextYear($aDate));
	EchoResult("First of Next Year after 1942-07-08", $dt->FirstOfNextYear('1942-07-08'));
	EchoResult("First of Next Year after 2004-01-1 07:08", $dt->FirstOfNextYear('2004-01-1 07:08'));
	EchoResult("First of Next Year after 2003-03-08", $dt->FirstOfNextYear('2003-03-08','y.m.d'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfNextYear($badDate));
	EchoResult($badDate3, $dt->FirstOfNextYear($badDate3));

# end function
}

### First Of Prior Month for a given date
function TestFirstOfPriorMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("First Of Prior Month for a given date");
	EchoResult("First of Prior month before now", $dt->FirstOfPriorMonth());
	EchoResult("First of Prior month before $aDate", $dt->FirstOfPriorMonth($aDate));
	EchoResult("First of Prior month before 1942-07-08", $dt->FirstOfPriorMonth('1942-07-08'));
	EchoResult("First of Prior month before 2004-02-1", $dt->FirstOfPriorMonth('2004-02-1'));
	EchoResult("First of Prior month before leap month 2004-02-29",
		$dt->FirstOfPriorMonth('2004-2-29'));
	EchoResult("First of Prior month before 2003-03-08",
		$dt->FirstOfPriorMonth('2003-03-08','y.m.d'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfPriorMonth($badDate));
	EchoResult($badDate3, $dt->FirstOfPriorMonth($badDate3));

# end function
}

### First of Prior Week for a given date
function TestFirstOfPriorWeek() {
	global $dt, $aDate, $badDate,$badDate3;

	EchoTitle("First of Prior Week for a given date");
	EchoResult("First of Prior Week before now", $dt->FirstOfPriorWeek());
	EchoResult("First of Prior Week before $aDate", $dt->FirstOfPriorWeek($aDate));
	EchoResult("First of Prior Week before 1942-07-08", $dt->FirstOfPriorWeek('1942-07-08'));
	EchoResult("First of Prior Week before 2014-02-09 07:08", $dt->FirstOfPriorWeek('2014-02-09 07:08'));
	EchoResult("First of Prior Week before 2003-03-08", $dt->FirstOfPriorWeek('2003-03-08','y.m.d'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfPriorWeek($badDate));
	EchoResult($badDate3, $dt->FirstOfPriorWeek($badDate3));

# end function
}

### First Of Prior Year for a given date
function TestFirstOfPriorYear() {
	global $dt, $aDate, $badDate,$badDate3;

	EchoTitle("First of Prior Year for a given date");
	EchoResult("First of Prior Year before now", $dt->FirstOfPriorYear());
	EchoResult("First of Prior Year before $aDate", $dt->FirstOfPriorYear($aDate));
	EchoResult("First of Prior Year before 1942-07-08 as m/d/y", $dt->FirstOfPriorYear('1942-07-08', 'm/d/y'));
	EchoResult("First of Prior Year before 2014-1-1 07:08", $dt->FirstOfPriorYear('2014-1-1 07:08'));
	EchoResult("First of Prior Year before 2003-03-08 as y.m.d", $dt->FirstOfPriorYear('2003-03-08','y.m.d'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfPriorYear($badDate));
	EchoResult($badDate3, $dt->FirstOfPriorYear($badDate3));

# end function
}

### First Of the Month for a given date
function TestFirstOfThisMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("First Of the Month for a given date");
	EchoResult("First of the month for 1942-07-08 03:23 pm", $dt->FirstOfThisMonth('1942-07-08 03:23 pm'));
	EchoResult("First of the month for now", $dt->FirstOfThisMonth());
	EchoResult("First of the month for $aDate", $dt->FirstOfThisMonth($aDate));
	EchoResult("First of the month for 2004-02-1", $dt->FirstOfThisMonth('2004-02-1'));
	EchoResult("First of the month for leap month 2004-02-29", $dt->FirstOfThisMonth('2004-02-29'));
	EchoResult("First of the month for 2003-03-08", $dt->FirstOfThisMonth('2003-03-08'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfThisMonth($badDate));
	EchoResult($badDate3, $dt->FirstOfThisMonth($badDate3));

# end function
}

### First Of the Week for a given date
function TestFirstOfThisWeek() {
	global $dt, $aDate, $badDate,$badDate3;

	EchoTitle("First of the Week for a given date");
	EchoResult("First of the Week for now", $dt->FirstOfThisWeek());
	EchoResult("First of the Week for $aDate", $dt->FirstOfThisWeek($aDate));
	EchoResult("First of the Week for 1942-07-08", $dt->FirstOfThisWeek('1942-07-08'));
	EchoResult("First of the Week for 2004-02-29", $dt->FirstOfThisWeek('2004-02-29'));
	EchoResult("First of the Week for 2003-03-08 as y.m.d", $dt->FirstOfThisWeek('2003-03-08','y.m.d'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfThisWeek($badDate));
	EchoResult($badDate3, $dt->FirstOfThisWeek($badDate3));

# end function
}

### First Of the Year for a given date
function TestFirstOfThisYear() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("First Of the Year for a given date");
	EchoResult("First of This Year for now", $dt->FirstOfThisYear());
	EchoResult("First of This Year for $aDate", $dt->FirstOfThisYear($aDate));
	EchoResult("First of This Year for 1942-07-08 03:44 am", $dt->FirstOfThisYear('1942-07-08 03:44 am'));
	EchoResult("First of This Year for 2003-03-08", $dt->FirstOfThisYear('2003-03-08'));
	EchoResult("First of This Year for 0077-03-08", $dt->FirstOfThisYear('0077-03-08'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->FirstOfThisYear($badDate));
	EchoResult($badDate3, $dt->FirstOfThisYear($badDate3));

# end function
}

### Get Last Error
function TestGetLastError() {
	global $dt;

	# show test title
	EchoTitle("Get Last Error");
	EchoResult("The last error is...", $dt->GetLastError());

# end function
}

### Greater Date - At least one date must be valid. Null does not default to now.
function TestGreaterDate() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Greater Date - missing dates are ignored");
	EchoResult("Greater of null vs $aDate as ymd", $dt->GreaterDate(null, $aDate, 'ymd'));
	EchoResult("Greater of $aDate vs null as y-m-d", $dt->GreaterDate($aDate, null,'y-m-d'));
	EchoResult("Greater of $aDate vs blank as m/d/y", $dt->GreaterDate($aDate, ' ','m/d/y'));
	EchoResult("Greater of $aDate vs 2013-04-05 as m.d.y", $dt->GreaterDate($aDate, '2013-04-05','m.d.y'));
	EchoResult("Greater of 2013-04-05 13:04:05 vs 02/3/2007 07:02:03 pm as y/m/d",
		$dt->GreaterDate( '2013-04-05 13:04:05','02/3/2007 07:02:03 pm','y/m/d'));
	EchoResult("Greater of 2013.04.05 1:04:05 pm vs 2013/04/05 10:04:05 am as m/d/y",
		$dt->GreaterDate( '2013.04.05 1:04:05 pm','2013/04/05 10:04:05 am','m/d/y'));
	EchoResult("Greater of 2013/04/05 10:04:05 am vs 2013.04.05 1:04:05 pm as m/d/y",
		$dt->GreaterDate('2013/04/05 10:04:05 am', '2013.04.05 1:04:05 pm','m/d/y'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->GreaterDate( $aDate, $badDate,'m/d/y'));
	EchoResult($badDate3, $dt->GreaterDate($badDate3, $aDate,'m/d/y'));

# end function
}

### Is A Date -- to see if a value looks like some kind of date.
function TestIsADate() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Is A Date");
	EchoResult("$aDate", $dt->IsADate( $aDate));
	EchoResult("05/10/2013 13:05:10", $dt->IsADate('05/10/2013 13:05:10'));
	EchoResult("2013.05.10 13:05:10", $dt->IsADate('2013.05.10 13:05:10'));
	EchoResult("20130510", $dt->IsADate('20130510'));

	# bad dates
	EchoMsg("..... Show ERRORS .....");
	EchoResult("null", $dt->IsADate(null));
	EchoResult("blank", $dt->IsADate(' '));
	EchoResult("05/1a/2013", $dt->IsADate('05/1a/2013'));
	EchoResult("02/29/1900", $dt->IsADate('02/29/1900'));
	EchoResult($badDate, $dt->IsADate($badDate));
	EchoResult($badDate3, $dt->IsADate($badDate3));

# end function
}

### Is The First of month
function TestIsTheFirst() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Is The First");
	EchoResult("Is now 1st of month?", $dt->IsTheFirst());
	EchoResult("Is $aDate 1st of month?", $dt->IsTheFirst($aDate));
	EchoResult("Is 2001-6-1 12:23 1st of month?", $dt->IsTheFirst('2001-6-1 12:23'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("$badDate", $dt->IsTheFirst($badDate));
	EchoResult("$badDate3", $dt->IsTheFirst($badDate3));

## end function
}

### Julian value to Date
function TestJulianToDate() {
	global $dt;

	# show test title
	EchoTitle("Julian Integer To Date");
	EchoResult("Julian string '2732746' ", $dt->JulianToDate('2732746', 'y-m-d'));
	EchoResult("Lowest Julian value for 01/01/0032 as m.d.y", $dt->JulianToDate(1732746, 'm.d.y'));
	EchoResult("Julian string '2711746 03:04' ", $dt->JulianToDate('2711746 03:04', 'y-m-d'));

	# bad data
	EchoMsg("..... Show ERRORS .....");
	EchoResult("x1010", $dt->JulianToDate('x1010', 'y-m-d'));

# end function
}

### Last day of the week for a month
function TestLastDowForAMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Last DOW For The Month");

	EchoResult("Last Fri of $aDate as m/d/y", $dt->LastDowForAMonth('Fri', $aDate, 'm/d/y'));
	EchoResult("Last Fri of for now as y.m.d", $dt->LastDowForAMonth('Fri', null, 'y.m.d'));
	EchoResult("Last Sat of 2014-05-06 with default format", $dt->LastDowForAMonth('Sat', '2014-05-06'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult("$badDate", $dt->LastDowForAMonth('Sat', $badDate));
	EchoResult("$badDate3", $dt->LastDowForAMonth('Sat', $badDate3));
	EchoResult("Last Sat of May 2014 with default format", $dt->LastDowForAMonth('Sat', $badDate));
	EchoResult("Last Frx of May 2014 ", $dt->LastDowForAMonth('Frx', '2014-05-06'));

# end function
}

### Lesser Date -- At least one date must be valid. Null does not default to now.
function TestLesserDate() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Lesser Date - missing dates are ignored");

	EchoResult("Lesser null vs $aDate as ymd", $dt->LesserDate(null, $aDate, 'ymd'));
	EchoResult("Lesser $aDate vs null", $dt->LesserDate( $aDate, null));
	EchoResult("Lesser $aDate vs blank as y-m-d", $dt->LesserDate( $aDate, '','y-m-d'));
	EchoResult("Lesser of $aDate vs 2013-04-05 as m/d/y", $dt->LesserDate( $aDate, '2013-04-05','m/d/y'));
	EchoResult("Lesser of 2013-04-05 13:34 vs 02/3/2007 07:22 AM as m/d/y",
		$dt->LesserDate( '2013-04-05 13:34','02/3/2007 07:22 AM','m/d/y'));
	EchoResult("Lesser of 02/3/2007 17:22 vs 02/3/2007 09:22 as m.d.y",
		$dt->LesserDate( '02/3/2007 17:22','02/3/2007 09:22','m.d.y'));
	EchoResult("Lesser of 02/3/2007 09:22 vs 02/3/2007 05:22 pm as m.d.y",
		$dt->LesserDate('02/3/2007 09:22', '02/3/2007 05:22 pm','m.d.y'));

	EchoMsg("..... Show ERRORS .....");
	EchoResult("2 bad dates", $dt->LesserDate( $badDate,$badDate,'m/d/y'));
	EchoResult("1 bad date with null", $dt->LesserDate($badDate3,'','m/d/y'));
	EchoResult($badDate, $dt->LesserDate( $aDate, $badDate,'m/d/y'));

# end function
}

### Maximum Date. Null dates default to now.
function TestMaximumDate() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Maximum Date - missing dates default to now");
	EchoResult("Maximum of 2010-2-3 or now", $dt->MaximumDate('2010-2-3'));
	EchoResult("Maximum of $aDate or 2010-2-5 as m/d/y",
		$dt->MaximumDate($aDate, '2010-2-5', 'm/d/y'));

	# if using time blocks
	if ($dt->UseTimeBlocks()) {
		EchoResult("Maximum of 02/3/2007 5:22:00 PM vs 2/03/2007 09:22 as m/d/y",
			$dt->MaximumDate( '02/3/2007 5:22:00 PM','02/3/2007 09:22','m/d/y'));

		EchoResult("Maximum of 2/03/2007 09:22 vs 02/3/2007 5:22:00 PM as m/d/y",
			$dt->MaximumDate( '02/3/2007 09:22','02/3/2007 5:22:00 PM','m/d/y'));

		EchoResult("Maximum of 01/3/2007 17:22 vs 2/03/2007 09:22 as m/d/y",
			$dt->MaximumDate( '01/3/2007 17:22','02/3/2007 09:22','m/d/y'));

	# ....
	}

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->MaximumDate($badDate));
	EchoResult($badDate3, $dt->MaximumDate($badDate3));

## end function
}

### Minimum Date. Null dates default to now.
function TestMinimumDate() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Minimum Date - missing dates default to now");
	EchoResult("Minimum of 2010-2-3 07:08 or now", $dt->MinimumDate('2010-2-3 07:08'));
	EchoResult("Minimum of 2050-2-3 07:08 or now", $dt->MinimumDate('2050-2-3 07:08'));
	EchoResult("Minimum of $aDate or 2010-2-5", $dt->MinimumDate($aDate, '2010-2-5'));

	# if using time blocks
	if ($dt->UseTimeBlocks()) {

		EchoResult("Minimum of 2008-08-08 08:34:00 vs 2010-2-5 10:23",
			$dt->MinimumDate('2008-08-08 08:34:00', '2010-2-5 10:23'));
		EchoResult("Minimum '02/3/2007 17:22' vs '20070203 09:22' as m/d/y",
			$dt->MinimumDate( '02/3/2007 17:22','20070203 09:22','m/d/y'));
	# ....
	}

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->MinimumDate($badDate));
	EchoResult($badDate3, $dt->MinimumDate($badDate3,'2010-2-3'));

# end function
}

### Mon Day Year. Null date defaults to now.
function TestMonthDayYear() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Mon Day Year");
	EchoResult("Mon day, year for null", $dt->MonthDayYear());
	EchoResult("Mon day, year for $aDate", $dt->MonthDayYear($aDate));
	EchoResult("Mon day, year for 2011-7-6", $dt->MonthDayYear('2011-7-6'));
	EchoResult("Mon day, year for leap day 2004-2-29 12:34:00", $dt->MonthDayYear('2004-2-29 12:34:00'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("$badDate", $dt->MonthDayYear($badDate));
	EchoResult("$badDate3", $dt->MonthDayYear($badDate3));
	EchoResult("1900-02-29", $dt->MonthDayYear('1900-02-29'));

# end function
}

### Month Number -- Only 1st three characters of month name are used.
function TestMonthNumber() {
	global $dt;

	# show test title
	EchoTitle("Month Number");
	EchoResult("Test month number for September", $dt->MonthNumber('September'));
	EchoResult("Test month number for Jun", $dt->MonthNumber('Jun'));

	# when an month name is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Invalid month jal = ", $dt->MonthNumber('jal'));

# end function
}

### Month String - return a 3-character month for a given date
function TestMonthStr() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Month to Str");
	EchoResult("Month string for $aDate", $dt->MonthStr($aDate));
	EchoResult("Month string for now", $dt->MonthStr());
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->MonthStr($badDate));
	EchoResult($badDate3, $dt->MonthStr($badDate3));

# end function
}

### N days before end of the month
function TestNDaysBeforeEndOfTheMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("N Days Before End Of The Month");
	EchoResult("5 days before end of month from 2000-6-13",
		$dt->NDaysBeforeEndOfTheMonth(5,'2000-6-13', 'y.m.d'));

	EchoResult("7 days before end of month from $aDate",
		$dt->NDaysBeforeEndOfTheMonth(7, $aDate));

	EchoResult("27 days before end of 20110615",
		$dt->NDaysBeforeEndOfTheMonth(27, 20110615));
	EchoResult("6 days before end of the month for now",
		$dt->NDaysBeforeEndOfTheMonth(6));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult(" $badDate",
		$dt->NDaysBeforeEndOfTheMonth(5, $badDate));
	EchoResult(" $badDate3",
		$dt->NDaysBeforeEndOfTheMonth(5, $badDate3));
	EchoResult("35 days before end of $aDate",
		$dt->NDaysBeforeEndOfTheMonth(35, $aDate));
	EchoResult("'ten' days before end of $aDate",
		$dt->NDaysBeforeEndOfTheMonth('ten', $aDate));

# end function
}

### Next Day Of Week
function TestNextDayOfTheWeek() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Next Day Of The Week");
	EchoResult("The next Thurday from now is", $dt->NextDayOfTheWeek('Thurs'));
	EchoResult("The next Friday from 2000-6-13 09:34:00 is", $dt->NextDayOfTheWeek('Fri','2000-6-13 09:34:00'));
	EchoResult("The next Monday from $aDate is", $dt->NextDayOfTheWeek('Monday',$aDate));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->NextDayOfTheWeek('Mon',$badDate));
	EchoResult($badDate3, $dt->NextDayOfTheWeek('Mon',$badDate3));

	# when an invalid day of week is sent
	EchoResult("Bad day Moxday $aDate", $dt->NextDayOfTheWeek('Mox',$aDate));

# end function
}

### Next First Of The Month
function TestNextFirstOfTheMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Next First Of The Month");
	EchoResult("Next 1st of month from now", $dt->NextFirstOfTheMonth(null));
	EchoResult("Next 1st of month from $aDate", $dt->NextFirstOfTheMonth($aDate));
	EchoResult("Next 1st of month from 2011-09-01", $dt->NextFirstOfTheMonth('2011-09-01'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Next 1st of month", $dt->NextFirstOfTheMonth($badDate));
	EchoResult("Next 1st of month", $dt->NextFirstOfTheMonth($badDate3));

# end function
}

### next 1st of the year
function TestNextFirstOfTheYear() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Next First Of The Year");

	EchoResult("Next 1st of the year from now", $dt->NextFirstOfTheYear(null));
	EchoResult("Next 1st of the year from $aDate", $dt->NextFirstOfTheYear($aDate));
	EchoResult("Next 1st of the year from 2011-09-01", $dt->NextFirstOfTheYear('2011-09-01'));
	EchoResult("Next 1st of the year from 2012-01-01", $dt->NextFirstOfTheYear('2012-01-01'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Next 1st of the year", $dt->NextFirstOfTheYear($badDate));
	EchoResult("Next 1st of the year", $dt->NextFirstOfTheYear($badDate3));

# end function
}

### Next Nth Day Of The Month
function TestNextNthDayOfTheMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Next Nth Day Of The Month");
	EchoResult("Next 1st Monday of month from 2011-09-01 08:23",
		$dt->NextNthDayOfTheMonth(1, 'Mon','2011-09-01 08:23' ));

	EchoResult("Next 3rd Friday of month from $aDate", $dt->NextNthDayOfTheMonth(3, 'Fri', $aDate));
	EchoResult("Next 4th Friday of month from now", $dt->NextNthDayOfTheMonth(4, 'Fri', null, 'ymd'));

	EchoResult("Next 5th Friday of month from $aDate", $dt->NextNthDayOfTheMonth(5, 'Fri',$aDate));
	EchoResult("Next 5th Friday of month from 20140607", $dt->NextNthDayOfTheMonth(5, 'Fri','20140607'));

	# errors
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Next 3rd Friday of month from $badDate", $dt->NextNthDayOfTheMonth(3, 'Fri', $badDate));
	EchoResult("Next 3rd Friday of month from $badDate3", $dt->NextNthDayOfTheMonth(3, 'Fri', $badDate3));
	EchoResult("Next 3rd Fro-day of month from $aDate", $dt->NextNthDayOfTheMonth(3, 'Fro', $aDate));

# end function
}

### Next Nth from The given Month
function TestNextNthOfTheMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Next Nth Of The Month");

	EchoResult("Next 19th of month from 2011-09-18 05:06", $dt->NextNthOfTheMonth(19, '2011-09-18 05:06'));
	EchoResult("Next 19th of month from 2011-09-19 06:07", $dt->NextNthOfTheMonth(19, '2011-09-19 06:07'));
	EchoResult("Next 19th of month from 2011-09-20", $dt->NextNthOfTheMonth(19, '2011-09-20'));
	EchoResult("Next 19th of month from 20110920", $dt->NextNthOfTheMonth(19, '20110920'));
	EchoResult("Next 19th of month from now", $dt->NextNthOfTheMonth(19, null));
	EchoResult("Next 30th of month after 2011-01-31", $dt->NextNthOfTheMonth(30, '2011-01-31'));
	EchoResult("Next 19th of month from $aDate as m/d/y", $dt->NextNthOfTheMonth(19, $aDate, 'm/d/y'));
	EchoResult("Next 31st of month from 2011-09-19 06:07", $dt->NextNthOfTheMonth(31, '2011-09-19 06:07'));


	# ERRORS only N values 1-31 are allowed
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Next 32th of month from 2012-01-30", $dt->NextNthOfTheMonth(32, '2012-01-30'));
	EchoResult("Next 19th of month from $badDate", $dt->NextNthOfTheMonth(19, $badDate));
	EchoResult("Next 19th of month from $badDate3", $dt->NextNthOfTheMonth(19, $badDate3));

# end function
}

### return the date for the Nth of the given month
function TestNthOfTheMonth() {

	global $dt, $aDate, $badDate,$badDate3;
	# show test title
	EchoTitle("Nth Of The Given Month");

	EchoResult("19th of month for 2011-09-18 05:06", $dt->NthOfTheMonth(19, '2011-09-18 05:06'));
	EchoResult("31st of month for 2011-10-19 06:07", $dt->NthOfTheMonth(31, '2011-10-19 06:07'));
	EchoResult("19th of month for 2011-09-20", $dt->NthOfTheMonth(19, '2011-09-20'));
	EchoResult("19th of month for now", $dt->NthOfTheMonth(19, null));
	EchoResult("29th of leap year February 2012-02-15", $dt->NthOfTheMonth(29, '2012-02-15'));
	EchoResult("19th of month for $aDate", $dt->NthOfTheMonth(19, $aDate, 'm/d/y'));

	# ERRORS only N values 1-31 are allowed
	EchoMsg("..... Show ERRORS .....");
	EchoResult("32nd of month for 2012-01-30...", $dt->NthOfTheMonth(32, '2012-01-30'));
	EchoResult("29th of non-leap year February 2011-02-15...", $dt->NthOfTheMonth(29, '2011-02-15'));
	EchoResult("19th of month for $badDate...", $dt->NthOfTheMonth(19, $badDate));
	EchoResult("19th of month for $badDate3...", $dt->NthOfTheMonth(19, $badDate3));
	EchoResult("31st of September 2012-09-15...", $dt->NthOfTheMonth(31, '2012-09-15'));

# end function
}

### Number Of Days In A Month - return the number of days in a month
function TestNumberOfDaysInAMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Number Of Days In A Month");
	EchoResult("today's month", $dt->NumberOfDaysInAMonth());

	EchoResult("$aDate", $dt->NumberOfDaysInAMonth($aDate));
	EchoResult("02/22/1942", $dt->NumberOfDaysInAMonth('02/22/1942'));
	EchoResult("2000-02-22", $dt->NumberOfDaysInAMonth('2000-02-22'));
	EchoResult("02.22.2004", $dt->NumberOfDaysInAMonth('02.22.2004'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("$badDate", $dt->NumberOfDaysInAMonth($badDate));
	EchoResult("$badDate3", $dt->NumberOfDaysInAMonth($badDate3));

# end function
}

### Numeric Day Of The Week -- Returns 0-6
function TestNumericDayOfTheWeek() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Numeric Day (0-6) Of The Week");

	EchoResult("Numeric day of week for now", $dt->NumericDayOfTheWeek(null));
	EchoResult("Numeric day of week for $aDate", $dt->NumericDayOfTheWeek($aDate));
	EchoResult("Numeric day of week for 1942-2-25 10:19",
		$dt->NumericDayOfTheWeek('1942-2-25 10:19'));
	EchoResult("Numeric day of week for 2012-1-3", $dt->NumericDayOfTheWeek('2012-1-3'));
	EchoResult("Numeric day of week for 2012-09-16", $dt->NumericDayOfTheWeek('2012-09-16'));
	EchoResult("Numeric day of week for 2012-08-11", $dt->NumericDayOfTheWeek('2012-08-11'));
	EchoResult("Numeric day of week for 1942-2-25", $dt->NumericDayOfTheWeek('1942-2-25'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Numeric day of week for bad date", $dt->NumericDayOfTheWeek($badDate));
	EchoResult("Numeric day of week for $badDate3", $dt->NumericDayOfTheWeek($badDate3));

# end function
}

### Numeric Month -- Returns 1-12
function TestNumericMonth() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Numeric Month");
	EchoResult("Numeric month for now", $dt->NumericMonth());
	EchoResult("Numeric month for 2/25/1980 12:34", $dt->NumericMonth('2/25/1980 12:34'));
	EchoResult("Numeric month for $aDate", $dt->NumericMonth($aDate));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Numeric month for $badDate", $dt->NumericMonth($badDate));
	EchoResult("Numeric month for $badDate3", $dt->NumericMonth($badDate3));

# end function
}

### Numeric Year -- Returns 32 - 9999
function TestNumericYear() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Numeric year");
	EchoResult("Numeric year for now", $dt->NumericYear());
	EchoResult("Numeric year for 2/25/1980 12:34", $dt->NumericYear('2/25/1980 12:34'));
	EchoResult("Numeric year for $aDate", $dt->NumericYear($aDate));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Numeric year for $badDate", $dt->NumericYear($badDate));
	EchoResult("Numeric year for $badDate3", $dt->NumericYear($badDate3));

# end function
}


### Prior Day Of Week
function TestPriorDayOfTheWeek() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Prior Day Of The Week");
	EchoResult("The Prior Thursday from now was", $dt->PriorDayOfTheWeek('Thurs'));
	EchoResult("The Prior Friday from 2000-6-13 11:22 was", $dt->PriorDayOfTheWeek('Fri', '2000-6-13 11:22'));
	EchoResult("The Prior monday from $aDate was", $dt->PriorDayOfTheWeek('monday',$aDate));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Bad date $badDate", $dt->PriorDayOfTheWeek('Mon', $badDate));
	EchoResult("Bad date $badDate3", $dt->PriorDayOfTheWeek('Mon', $badDate3));

	# when an invalid day of week is sent
	EchoResult("Bad day Moxday $aDate", $dt->PriorDayOfTheWeek('Mox',$aDate));

# end function
}

### Subtract Days
function TestSubtractDays() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Subtract Days - absolute number");

	# by default subtract 0 days from now
	EchoResult("Subtract 0 days from now", $dt->SubtractDays());

	# subtract 15 days to date with time element
	EchoResult("Subtract 15 days from 2011-02-24 12:34:56 PM",
		$dt->SubtractDays(15,'2011-02-24 12:34:56 PM'));

	# Subtract 10 days from now
	EchoResult("Subtract 10 days from now", $dt->SubtractDays(10));

	# Subtract 9 days and convert a date format
	EchoResult("Subtract 9 days from 2011-02-24 as m/d/y", $dt->SubtractDays(9,'2011-02-24 ', 'm/d/y'));

	# Subtract 9 days. Subtracts absolute value of days
	EchoResult("Subtract -9 days from 2011-02-24 ", $dt->SubtractDays(-9,'2011-02-24 '));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->SubtractDays(21,$badDate));
	EchoResult($badDate3, $dt->SubtractDays(21,$badDate3));
	EchoResult($aDate, $dt->SubtractDays('two',$aDate));

# end function
}

### Subtract Months
function TestSubtractMonths() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Subtract Months - absolute number");
	EchoResult("Subtract 1 month from 2012-01-31 9:44 Am", $dt->SubtractMonths(1,'2012-01-31 9:44 Am'));
	EchoResult("Subtract 1 month from 2012-03-31 9:44 Am", $dt->SubtractMonths(1,'2012-03-31 9:44 Am'));
	EchoResult("Subtract 1 month from 2011-03-31 9:44 Am", $dt->SubtractMonths(1,'2011-03-31 9:44 Am'));

	# subtracting a negative number does not result in adding
	EchoResult("Subtract -2 months from 2012-01-31 19:44", $dt->SubtractMonths(-2,'2012-01-31 19:44'));
	EchoResult("Subtract 21 months from 2012-01-31 09:34 as ymd", $dt->SubtractMonths(21,'2012-01-31 09:34', 'ymd'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->SubtractMonths(21,$badDate));
	EchoResult($badDate3, $dt->SubtractMonths(21,$badDate3));
	EchoResult($aDate, $dt->SubtractMonths('two',$aDate));

# end function
}

### Subtract Weeks
function TestSubtractWeeks() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Subtract Weeks - absolute number");
	EchoResult("Subtract 1 week from now", $dt->SubtractWeeks(1));

	EchoResult("Subtract 1 week from 2012-01-31 09:44", $dt->SubtractWeeks(1,'2012-01-31 09:44'));

	# subtracting a negative number does not result in adding
	EchoResult("Subtract -2 Weeks from 2012-01-31 09:44", $dt->SubtractWeeks(-2,'2012-01-31 09:44'));
	EchoResult("Subtract 21 Weeks from 2012-01-31 as y.m.d", $dt->SubtractWeeks(21,'2012-01-31', 'y.m.d'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->SubtractWeeks(21,$badDate));
	EchoResult($badDate3, $dt->SubtractWeeks(21,$badDate3));
	EchoResult($aDate, $dt->SubtractWeeks('two',$aDate));

# end function
}

### Subtract Years
function TestSubtractYears() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Subtract Years - absolute number");
	EchoResult("Subtract 1 Year from 2012-01-31 17:18", $dt->SubtractYears(1,'2012-01-31 17:18'));
	EchoResult("Subtract 1 Year from now", $dt->SubtractYears(1));

	# subtracting a negative number does not result in adding
	EchoResult("Subtract -2 Years from 2012-01-31 7:18 pm", $dt->SubtractYears(-2,'2012-01-31 7:18 pm'));
	EchoResult("Subtract 21 Years from 2012-07-23", $dt->SubtractYears(21,'2012-07-23'));
	EchoResult("Subtract 3 Years from leap day 2012-02-29 09:10 as m.d.y",
		$dt->SubtractYears(3,'2012-02-29 09:10', 'm.d.y'));
	EchoResult("Subtract 4 Years from leap day 2012-02-29 09:10 as m.d.y",
		$dt->SubtractYears(4,'2012-02-29 09:10', 'm.d.y'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->SubtractYears(2,$badDate));
	EchoResult($badDate3, $dt->SubtractYears(2,$badDate3));
	EchoResult($aDate, $dt->SubtractYears('two',$aDate));

# end function
}

### Week Number -- Returns numeric week of year 0- 53. Week 1 begins on a Sunday.
function TestWeekNumber() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Week Number");
	EchoResult("Week number for 2013-01-01 23:59", $dt->WeekNumber('2013-01-01 23:59'));
	EchoResult("Week number for now", $dt->WeekNumber());
	EchoResult("Week number for $aDate", $dt->WeekNumber($aDate));
	EchoResult("Week number for 2010-11-21", $dt->WeekNumber('2010-11-21'));

	EchoResult("Week number for 2014-1-1", $dt->WeekNumber('2014-1-1'));
	EchoResult("Week number for 2014-1-4", $dt->WeekNumber('2014-1-4'));
	EchoResult("Week number for 2014-1-5", $dt->WeekNumber('2014-1-5'));
	EchoResult("Week number for 2014-1-29", $dt->WeekNumber('2014-1-29'));

	# 2012-01-01 was Sunday
	EchoResult("Week number for 2012-1-2", $dt->WeekNumber('2012-1-2'));
	EchoResult("Week number for 2012-1-1", $dt->WeekNumber('2012-1-1'));

	# when an invalid date is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->WeekNumber($badDate));
	EchoResult($badDate3, $dt->WeekNumber($badDate3));

# end function
}

### Date to Ymd array
function TestYmd() {
	global $dt, $aDate, $badDate,$badDate3;

	# show test title
	EchoTitle("Ymd");

	# various arrangements of good dates return an array of Y M D
	EchoTitle("20010128");
		print_r($dt->Ymd('20010128'));
	EchoTitle("2801-04-05 12:34:56 PM");
		print_r($dt->Ymd('2801-04-05 12:34:56 PM'));
	EchoTitle("null");
		print_r($dt->Ymd());
	EchoTitle("$aDate");
		print_r($dt->Ymd($aDate));
	EchoTitle("2/25/1942");
		print_r($dt->Ymd('2/25/1942'));
	EchoTitle("2-25-1942");
		print_r($dt->Ymd('2-25-1942'));
	EchoTitle("2.25.1942");
		print_r($dt->Ymd('2.25.1942'));
	EchoTitle("1942-2-25");
		print_r($dt->Ymd('1942-2-25'));
	EchoTitle("42-2-25");
		print_r($dt->Ymd('42-2-25'));

	# when invalid dates are sent the result === false
	EchoMsg("..... Show ERRORS .....");
	EchoResult($badDate, $dt->Ymd($badDate));
	EchoResult("22/25/1942", $dt->Ymd("22/25/1942"));
	EchoResult($badDate3, $dt->Ymd($badDate3));

# end function
}

### Ymd Array To Date
function TestYmdArrayToDate() {
	global $dt,$aDate;

	# show test title
	EchoTitle("Ymd Array To Date");
	EchoResult("Array of 2001,1,28", $dt->YmdArrayToDate(array(2001, 1, 28)));
	$t = array('2002', '9', '20', '12:21');
	EchoResult("Array of '2002','9','20', '12:21'", $dt->YmdArrayToDate($t));

	# when an invalid array is sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Bad array of 2001,28,1", $dt->YmdArrayToDate(array(2001,28,1)));
	EchoResult("Bad array of xxx,28,1", $dt->YmdArrayToDate(array('xxx',28,1)));
	EchoResult("Bad array $aDate", $dt->YmdArrayToDate($aDate));

# end function
}

### Ymd String To Date.
function TestYmdStringToDate() {
	global $dt, $badDate3;

	# show test title
	EchoTitle("Ymd String To Date");
	EchoResult("String of 20010128", $dt->YmdStringToDate('20010128', 'm.d.y'));
	EchoResult("String of 20010128 12:23 AM", $dt->YmdStringToDate('20010128 12:23 AM'));
	EchoResult("String of 00510128", $dt->YmdStringToDate('00510128'));
	EchoResult("String of 20510128 23:24", $dt->YmdStringToDate('20510128 23:24'));

	# when bad strings are sent
	EchoMsg("..... Show ERRORS .....");
	EchoResult("Bad string month in $badDate3", $dt->YmdStringToDate($badDate3));
	EchoResult("Bad short string of 200128", $dt->YmdStringToDate('200128'));
	EchoResult("Bad numeric string of 20010928xx", $dt->YmdStringToDate('20010928xx'));

# end function
}

### toggle Exceptions
function ToggleExceptions() {
	global $dt;

	# swap true and false
	$set = $dt->UseExceptions()
		? false
		: true;

	# set exceptions
	$dt->UseExceptions($set);

	# show the revised state
	ShowStates();

# end function
}

### toggle Usetime
function ToggleUsetime() {
	global $dt;

	# swap true and false
	$set = $dt->UseTimeBlocks()
		? false
		: true;

	# set time blocks
	$dt->UseTimeBlocks($set);

	# show the revised state
	ShowStates();

# end function
}

# end script
?>