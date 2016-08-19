<?php

/*	Date_Math_ClassA.php

 	This class has 67 date related functions. Dates can be outside the Linux date() range of 1970- 2039.
	Date range for this class is from the year 0032 A.D. to 9999 A.D.

	USE:
	require_once <path / Date_Math_ClassA.php>;
	$dt = new date_math_class;

	Documentation and examples are found in files
		Date_Math_Class_TestA.php and
		Date_Math_ClassA.php.pseudo.

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

	This class operates by default on dates in string y-m-d format (y= year, m= month, d=day) as used in mySql;
		however you may opt for input and output formats to be different,
		and you can change the default output date format.

	Input dates as function parameters may be formatted as strings:
		y-m-d, y/m/d, y.m.d, m-d-y, m/d/y, m.d.y
		where 'y' is 4 digits (leading zeros for years before 1000), 'm' and 'd' may be 1 or 2 digits.

		Example: AddDays(2, '2013-04-15', 'y/m/d') means 2 days are added to April 15, 2014 and output
		is formatted as y/m/d.

	Also supported is ymd format as a string or integer for input which must be
		 exactly 8 digits: 4-digit year and 2-digit month and 2-digit day.

	Output date formats supported include those above as well as d-m-y by including an optional string parameter
		in the function call. Also included are dmy, mdy and ymd with exactly 8 digits. Examples: 'm/d/y' 'ymd'
		Note the 'd-m-y' format is not supported in the input date formats.

		Null or blank output date formats revert to the default format as do any other formats that are
			not recognized. Thus null, blank, or unrecognized formats do not generate errors.

		Formatting strings are not case sensitive.

	Input and output formats do not have to be the same. Thus functions can be
		used to convert date formats from one to another.

	For functions expecting an integer value as an input parameter, it may be
		either an integer or string with or without + or - signs that evaluates to an integer.

	When the public variable $useTime = false (the default),
		time blocks are not considered for calculations and are removed from the output.

	When the public variable $useTime = true,
		The input date string may have an optional time component which is preserved and returned.
		Time blocks are used in many date comparisons where time may make a difference.
		Any dates submitted without a valid time block are set to 00:00 (midnight).
		Null and blank time blocks are set to the current Linux local time.

		Date comparisons using time blocks operate on 24 hours (86400 seconds) to make one day.
		Thus 2012-07-08 09:00:00 versus 2012-07-09 08:59:59 is still the same day
		likewise 2012-07-08 09:00 versus 2012-07-07 09:01.
		When time blocks are not used, these entries result in different days.

	Public variables for months, days of the week and 1st day of the weekmake it easy to change languages.

	You can change the abbreviations for month and day of the week in public variables.

	When the public variable $exceptions = true, an error throws an exception instead of returning
		to the calling script with 'false' result.
		Otherwise functions return a boolean false (result === false) whenever invalid input is passed
		and should be explicitly tested by using ===.
		Some functions may return zero which is different from the boolean false.

	Null and blank dates are valid for input in selected functions where replacing them with the
		current date and time makes sense.

	When internal date calculations result in a non-existent date, such as April 31, the result
		is reduced to the last valid day of the month.

	Refer to the PHP script Date_Math_Class_Test.php for examples of how these functions
		can be used. If the test script is run via the console, the results of various functions are
		echoed to the console.

	This class was written such that the logical flow of each function is available in
		pseudo code form in a text file Date_Math_Class.php.pseudo.

	Naming convention: all functions begin with a capital letter;
		all variables begin with $ and lower case first letter.

	An inherant flaw exists with julian dates where years like 1700, 1800 and 1900 are not leap years
		yet there is a PHP julian value for Feb 29 in those years. If you work with dates that span Feb 29
		in a non-leap year, this date math class can render results that are off by one day.
		Example: adding 2 days to 1900-02-28 (jd 2415091) renders an invalid result of
		1900-03-01 (jd 2415093) since jd 2415092 is the non-existant date of 1900-02-29.

	The depth count variable keeps track of how many internal function calls are active
		and depth 1 serves to identify which function was called from the calling program.

	HINT: to get the entire call stack
	$stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
print_r($stack);

Functions included in this class are:

### Add Days - add (or subtract when negative) days to the given date.
function AddDays($days=0, $date=null, $fmt=null)

### Add Months - add (or subtract when negative) months to the given date.
function AddMonths($months=0, $date=null, $fmt=null)

### Add Weeks - add (or subtract when negative) weeks to the given date.
function AddWeeks($weeks=0, $date=null, $fmt=null)

### Add Years - add (or subtract when negative) years to the given date.
function AddYears($years=0, $date=null, $fmt=null)

### Age In Years - return the absolute age in years for one date versus another.
function AgeInYears($date1=null, $date2=null)

### Date Is Valid - return the valid date. Blank and null default to now.
function DateIsValid($date=null, $fmt=null, $which=1)

### Date To Julian - convert a date to integer julian days. Optional time block.
function DateToJulian($date=null)

### Day Month Year - return the date formatted as day month year like 30 Oct 2013.
function DayMonthYear($date=null)

### Day Of The Month - return the numeric day of the month.
function DayOfTheMonth($date=null)

### Day Of The Week - return the three-character short form for the day of the week for the given date.
function DayOfTheWeek($date=null)

### Day Of The Year - return the numeric day of the year for the given date. 1-365 or 366.
function DayOfTheYear($date=null)

### Day Of The Year To Date - convert the day of the year to a date in the given year.
function DayOfTheYearToDate($dayOfYear = 0, $year = null, $fmt=null)

### Difference In Days - return the difference between two dates in completed days based on Julian days.
function DifferenceInDays($date1=null, $date2=null)

### Difference In Weeks - return the difference in complete weeks for the dates given, not partial weeks.
function DifferenceInWeeks($date1=null, $date2=null)

### Difference In Years - return the difference between two dates in years, may be negative.
function DifferenceInYears($date1= null, $date2= null)

### Dow Month Day Year - return a date formatted as day-of-week, month, day, and year.
function DowMonthDayYear($date=null)

### End Of Next Month - return the end of next month.
function EndOfNextMonth($date=null, $fmt=null)

### End Of Next Week- return the end of next week.
function EndOfNextWeek($date=null, $fmt=null)

### End Of Next Year - return the end of next year.
function EndOfNextYear($date=null, $fmt=null)

### End Of Prior Month - return the end of the prior month.
function EndOfPriorMonth($date=null, $fmt=null)

### End Of Prior Week- return the end of the prior week.
function EndOfPriorWeek($date=null, $fmt=null)

### End Of Prior Year - return the end of the prior year.
function EndOfPriorYear($date=null, $fmt=null)

### End Of This Month - return the end of the month for the given date.
function EndOfThisMonth($date=null, $fmt=null)

### End Of This Week - return the end of the week for the given date.
function EndOfThisWeek($date=null, $fmt=null)

### End Of This Year - return the end of the year for the given date.
function EndOfThisYear($date=null, $fmt=null)

### First Of Given Month - return the next first of the month for the given month.
function FirstOfGivenMonth($mon=null, $date=null, $fmt=null)

### First Of Next Month - return the 1st of next month after the given date.
function FirstOfNextMonth($date=null, $fmt=null)

### First of Next Week - return the 1st of next week after the given date.
function FirstOfNextWeek($date=null, $fmt=null)

### First Of Next Year - return the 1st of next year after the given date.
function FirstOfNextYear($date=null, $fmt=null)

### First Of Prior Month - return the 1st of prior month from the given date.
function FirstOfPriorMonth($date=null, $fmt=null)

### First Of Prior Week- return the 1st of prior week from the given date.
function FirstOfPriorWeek($date=null, $fmt=null)

### First Of Prior Year - return the 1st of prior year from the given date.
function FirstOfPriorYear($date=null, $fmt=null)

### First Of This Month - return 1st of the month for the given date.
function FirstOfThisMonth($date=null, $fmt=null)

### First Of This Week - return 1st of the week for the given date.
function FirstOfThisWeek($date=null, $fmt=null)

### First Of This Year - return 1st of the year for the given date.
function FirstOfThisYear($date=null, $fmt=null)

### Get Last Error - return the last error message.
function GetLastError()

### Greater Date - return the greater of two dates ignoring any null or blank dates. At least one date must be provided.
function GreaterDate($date1=null, $date2=null, $fmt=null)

### Is A Date - return true when the given date looks like a date. Null and blank are not dates.
function IsADate($date=null)

### Is The First - true when the given date is the first of the month, zero when not, false when invalid date is sent.
function IsTheFirst($date=null)

### Julian To Date - convert an integer or integer string to a date string.
function JulianToDate($value=null, $fmt=null)

### Last Dow For A Month - return the last day of the week for the given date - for example: find the last Friday of a month.
function LastDowForAMonth($dayOfWeek, $date=null, $fmt=null)

### Lesser Date - return the lesser of two dates ignoring any null or blank dates. At least one date must be passed.
function LesserDate($date1=null, $date2=null, $fmt=null)

### Maximum Date - the maximum of two dates. Null and blank dates default to now.
function MaximumDate($date1=null, $date2=null, $fmt=null)

### Minimum Date - the lesser of two dates. Null and blank dates default to now.
function MinimumDate($date1=null, $date2=null, $fmt=null)

### Month Day Year - return a date formatted as 'month day, year' like Mar 3, 2005.
function MonthDayYear($date=null)

### Month Number - the integer month number for the named month.
function MonthNumber($mon=null)

### Month Str - return the 3-char string for the month of the given date.
function MonthStr($date=null)

### N Days Before End Of The Month - return N days before the end of the month for the given date.
function NDaysBeforeEndOfTheMonth($n=0, $date = null, $fmt= null)

### Next Day Of The Week - return the next date for a named day of the week when given date is not same as the day sent.
function NextDayOfTheWeek($dayOfWeek, $date=null, $fmt=null)

### Next First Of The Month - the next first of the month if the given date is not the 1st.
function NextFirstOfTheMonth($date=null, $fmt=null)

### Next First Of The Year - the next first of the year if the given date is not the 1st.
function NextFirstOfTheYear($date=null, $fmt=null)

### Next Nth Day Of The Month - the next Nth day of the month after the given date, e.g. 3rd Tuesday.
function NextNthDayOfTheMonth($n=1, $dayOfWeek, $date=null, $fmt=null)

### Next Nth Of The Month - advance as needed to the next Nth day of a month limited to 1-31.
function NextNthOfTheMonth($n=0, $date=null, $fmt=null)

### Nth Of The Month - return Nth day of the month for the given date limited to 1-31.
function NthOfTheMonth($n=0, $date=null, $fmt=null)

### Number Of Days In A Month - return a count of the number of days in a month.
function NumberOfDaysInAMonth($date=null)

### Numeric Day Of The Week - return the numeric day of the week 0-6 based on the public day array.
function NumericDayOfTheWeek($date=null)

### Numeric Month - return the numeric month (1-12) for the given date.
function NumericMonth($date = null)

### Numeric Year - return the numeric year for the given date.
function NumericYear($date = null)

### Prior Day Of The Week - return the date for the prior day of the week from the given date. Back up, if needed.
function PriorDayOfTheWeek($dayOfWeek, $date=null, $fmt=null)

### Subtract Days - subtract absolute number of days from the given date.
function SubtractDays($days=0, $date=null, $fmt=null)

### Subtract Months - subtract absolute number of months from the given date.
function SubtractMonths($months=0, $date=null, $fmt=null)

### Subtract Weeks - subtract absolute number of weeks from the given date.
function SubtractWeeks($weeks=0, $date=null, $fmt=null)

### Subtract Years - subtract absolute number of years from the given date.
function SubtractYears($years=0, $date=null, $fmt=null)

### Use Exceptions - opt to set exceptions on or off and return the state.
function UseExceptions($state=null)

### Use Time Blocks - opt to set using time blocks on or off and return the state.
function UseTimeBlocks($state=null)

### Week Number - return the week number (0-53) of the year, weeks begin on the first day in the day array.
function WeekNumber($date=null)

### Ymd - convert a date to an array of year, month, day from a date. Optional time block.
function Ymd($date=null)

### Ymd Array To Date - convert a YMD array to a date string.
function YmdArrayToDate($ymdArray=null, $fmt=null)

### Ymd String To Date - convert a string in the form of yyyymmdd to a date. Optional time block.
function YmdStringToDate($yyyymmdd=null, $fmt=null)

######## Private functions #####
### Add Time Block - return a date with time block appended when time blocks are used
private function AddTimeBlock($date, $tb=false)

### Blank Item - true when what is passed is a blank string.
private function BlankItem($item)

### Day Is Valid - return 3-char day when the day is in the week-day array.
private function DayIsValid($dayOfWeek)

### Default Date - default a date to today when the date is null or blank. This does not validate the date.
private function DefaultDate($date=null)

### Format A Date - format a date using the requested format string.
private function FormatADate($date, $fmt=null)

### Fresh Start - set global variables for a fresh start.
private function FreshStart()

### Get Date Only - get the date part without the time block.
private function GetDateOnly($date)

### Get The Time Block - return an appropriate time block from a date.
private function GetTheTimeBlock($date)

### Get a YMD array with any time block removed.
private function GetYmdArray($date, $includeTime=true)

### Go Deeper - add one to the internal depth count.
private function GoDeeper()

### Go Up - subtract one from the depth count.
private function GoUp()

### Greater Time Block - return the greater of two time blocks (1, 2, or zero when identical).
private function GreaterTimeBlock($tb1 = '0:0', $tb2 ='0:0' )

### Integer Or String Value - return the value as an integer.
private function IntegerOrStringValue($in= false)

### Integer Range - true when a value is in the 'from' and 'to' range.
private function IntegerRange($x, $from, $to)

### Julian Value - convert a date to Julian integer without the time block.
private function JulianValue($date)

### Mon Year - format a date as 'mon year' like Mar 2005.
private function MonYear($date=null)

### Null Date - true when what is passed is null.
private function NullItem($item=null)

### Return Result - go up one level in the depth and return the given result.
private function ReturnResult($result)

### Set Error Message - set an error message in the public error variable.
private function SetErrorMessage($msg, $goback=1)

### Set Invalid Date Message in the public variable  for the lastError.
private function SetInvalidDateMessage($x)

### Set Invalid Day Of Week Message in the public variable  for the lastError.
private function SetInvalidDowMessage($x)

### Set Invalid Integer Message in the public variable  for the lastError.
private function SetInvalidIntegerMessage($x)

### Set An Invalid Message in the public variable  for the lastError.
private function SetInvalidMsg($msg='', $back = 2)

### String of Digits Only - returns only digits 0-9 as a string which may have leading zeros.
private function StringOfDigitsOnly($in=null)

### Time Block Value - return the integer value in seconds since midnight of a time block.
private function TimeBlockValue($aTime=false)

### Valid Format - return a valid format string.
private function ValidFormat($fmt=null)

### Valid Time Block - return the time block when it is valid.
private function ValidTimeBlock($aTime = null)
*/

### declare the date_math_class
class date_math_class {

	# the public variables below can be changed for different languages
	# array of month abbreviations all upper case
	public $monthArray = array("JAN","FEB","MAR","APR", "MAY","JUN",
			"JUL","AUG","SEP","OCT","NOV","DEC");

	# The base date below assumes the week begins on a Sunday and needs to agree with the
	# first element in the day-of-week array below.  Feb 1, 1942 was a Sunday.
	public $baseDate = '1942-02-01';

	# array of day-of-week abbreviations all upper case
	public $dayArray = array('SUN','MON','TUE','WED','THU','FRI','SAT');

	# the public variables below can be changed for different preferences for defaults.
	# default output date format
	public $defaultFormat = "y-m-d";

	# initialize PUBLIC variables
	public $exceptions = false;
	public $useTime = false;
	public $lastError = "no error :-) ";

	# declare PRIVATE variables
	private $julianBase;
	private $minJulian;

	# initialize PRIVATE variables
	private $validDate = array();
	private $depth = 0;

### __construct() construct the class
function __construct() {

	# initialize control variables
	$this->FreshStart();

	# initialize the julian date for the base date
	$this->julianBase = $this->JulianValue($this->baseDate);

	# the minimum Julian integer value is that for year 0032
	$this->minJulian = $this->JulianValue('0032/01/01');

# end function
}

### Add Days - add (or subtract when negative) days to the given date.
function AddDays($days=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if days are given as an integer or integer string
	if ($this->IntegerOrStringValue($days) !== false) {

		# if input is a valid date
		if ($good = $this->DateIsValid($date)) {

			# hold the time block
			$tb = $this->GetTheTimeBlock($good);

			# use integer value for days
			$days = intval($days);

			# convert date to julian
			$jdays = $this->JulianValue($good);

			# apply the plus or minus increment
			$jdays += $days;

			# convert Julian to JD (mm/dd/yyyy)
			$jd = $this->JulianToDate($jdays);

			# when the new date does not exist like Feb 29, 1900
			# loop until there is a good date
			while (! $jd) {

				# add or subtract one more julian count
				$jdays += ($days > 0)
					? 1
					:-1;

				# convert Julian to JD (mm/dd/yyyy)
				$jd = $this->JulianToDate($jdays);

			# <---
			}

			# append the appropriate time block
			$jd = $this->AddTimeBlock($jd, $tb) ;

			# format the resulting date
			$result = $this->FormatADate($jd, $fmt);

		# else
		} else {

			# report an invalid date
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# report an error with days
		$result = $this->SetErrorMessage("Invalid number of days <$days>");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Add Months - add (or subtract when negative) months to the given date.
function AddMonths($months=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if months are given as an integer or integer string
	if ($this->IntegerOrStringValue($months) !== false) {

		# if the given date is valid
		if ($good = $this->DateIsValid($date)) {

			# capture the time block
			$tb = $this->GetTheTimeBlock($good);

			# make a YMD array
			$parts = $this->GetYmdArray($good, false);

			# add months to month part of a YMD array
			$parts[1] = $parts[1] +intval($months);

			# loop while mon > 12 (adding months)
			while ($parts[1] > 12) {

				# add a year and subtract 12 months
				$parts[0]++;
				$parts[1] -= 12;
			# <---
			}

			# loop while mon < 1 (subtracting months)
			while ($parts[1] < 1) {

				# subtract a year and add 12 months
				$parts[0]--;
				$parts[1] += 12;
			# <---
			}

			# loop until checkdate says it is a valid date -- because there may be fewer days in the new month
			while (! checkdate($parts[1], $parts[2], $parts[0])) {

				# back up one day
				$parts[2]--;

			# <---
			}

			# build the resulting date with dashes
			$newDate = implode('-', $parts);

			# append appropriate time block
			$newDate = $this->AddTimeBlock($newDate,$tb);

			# return the date in desired format
			$result = $this->FormatADate($newDate, $fmt);

		# else
		} else {

			# report an invalid date
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# report error with months
		$result = $this->SetErrorMessage("Invalid number of months <$months>");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Add Weeks - add (or subtract when negative) weeks to the given date.
function AddWeeks($weeks=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if weeks are given as an integer or integer string
	if ($this->IntegerOrStringValue($weeks) !== false) {

		# if adding (weeks *7) to days results in a good date.
		if ($good = $this->AddDays(($weeks *7), $date)) {

			# format the resulting date
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# report invalid date message
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# report error with weeks
		$result = $this->SetErrorMessage("Invalid number of weeks <$weeks>");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Add Years - add (or subtract when negative) years to the given date.
function AddYears($years=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if years are given as an integer or integer string
	$yrs = $this->IntegerOrStringValue($years);
	if ($yrs !== false) {

		# if adding (years * 12) to months results in a good date
		if ($good = $this->AddMonths($yrs*12, $date, $fmt)) {

			# format the resulting date
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# report the error with the given date
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# report invalid number of years
		$result = $this->SetErrorMessage("Invalid number of years <$years>");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Age In Years - return the absolute age in years for one date versus another.
function AgeInYears($date1=null, $date2=null) {

	# add to the depth count
	$this->GoDeeper();

	# if date 1 is valid
	if ($good1 = $this->DateIsValid($date1)) {

		# if date 2 is valid
		if ($good2 = $this->DateIsValid($date2,null,2)) {

			# determine absolute difference in years
			$result = abs($this->DifferenceInYears($good1, $good2));

		# else
		} else {

			# report date2 was invalid
			$result = $this->SetInvalidDateMessage($date2);
		# ....
		}

	# else
	} else {

		# report date 1 was invalid
		$result = $this->SetInvalidDateMessage($date1);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Date Is Valid - return the valid date. Blank and null default to now.
function DateIsValid($date=null, $fmt=null, $which=1) {

	# add to the depth count
	$depth = $this->GoDeeper();

	# if this is the first call to DateIsValid() for this date (1 or 2)
	if ($this->validDate[$which] === false) {

		# default to now when null or blank date
		$good = $this->DefaultDate($date);

		# if the date is truly a date
		if ($this->IsADate($good)) {

			# note that it has been validated
			$this->validDate[$which] = true;

			# format the result
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

	 		# report invalid date
	 		$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# this date has already been validated so return it
		$result = $date;
	# ....
	}

	# return the result
	$res = $this->ReturnResult($result);
	return  $res;

# end function
}

### Date To Julian - convert a date to integer julian days. Optional time block.
function DateToJulian($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good = $this->DateIsValid($date)) {

		# get the time block to use
		$tb = $this->GetTheTimeBlock($good);

		# get the julian value
		$result = $this->JulianValue($good);

		# append appropriate time block
		$result = $this->AddTimeBlock($result, $tb);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Day Month Year - return the date formatted as day month year like 30 Oct 2013.
function DayMonthYear($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good = $this->DateIsValid($date)) {

		# hold the time block
		$tb = $this->GetTheTimeBlock($good);

		# get a YMD array
		$ymd = $this->GetYmdArray($good);

		# start with the day
		$result = $ymd[2];

		# add the string for the month
		$result .= ' '.$this->MonthStr($good);

		# add the year
		$result .= ' '.$ymd[0] ;

		# add the time block
		$result = trim("$result $tb");

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Day Of The Month - return the numeric day of the month.
function DayOfTheMonth($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is found
	if ($good = $this->DateIsValid($date) ) {

		# get the YMD array
		$ymd = $this->GetYmdArray($good);

		# return day number
		$result = $ymd[2];

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Day Of The Week - return the three-character short form for the day of the week for the given date.
function DayOfTheWeek($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is found
	if ($good = $this->DateIsValid($date) ) {

		# get numeric day of the week
		$dow = $this->NumericDayOfTheWeek($good);

		# retrieve the day from the day array
		$result = $this->dayArray[$dow];

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Day Of The Year - return the numeric day of the year for the given date. 1-365 or 366.
function DayOfTheYear($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good = $this->DateIsValid($date)) {

		# get end of prior year to be day 0
		$day0 = $this->EndOfPriorYear($good);

		# result is difference in days from day 0 to the date provided
		$result = $this->DifferenceInDays($day0, $good);

	# else invalid date
	} else {

		 # report invalid date
		 $result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Day Of The Year To Date - convert the day of the year to a date in the given year.
function DayOfTheYearToDate($dayOfYear = 0, $year = null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if the year is null
	if (is_null($year)) {

		# use the current year
		$year = $this->NumericYear(null);
	# ....
	}

	# use year as integer
	$yr = $this->IntegerOrStringValue($year);

	# if year is between 0032 and 9999
	if (($yr !== false) and ($this->IntegerRange($yr, 32, 9999))) {

		# determine how many days are in the year
		$maxDays = $this->DayOfTheYear("$year/12/31");

		# use day of the year as integer
		$doy = $this->IntegerOrStringValue($dayOfYear);

		# if day is between 1 and maximum days
		if (($doy !== false) and ($this->IntegerRange($doy, 1, $maxDays))) {

			# build a date for 1st of the given year
			$good = $this->YmdArrayToDate(array($year, 1, 1));

			# add day of the year minus 1 to the date
			$good = $this->AddDays(--$dayOfYear, $good);

			# format the resulting date
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# it is an invalid day
			$result = $this->SetErrorMessage("Invalid day <$dayOfYear> for $year");
		# ....
		}

	# else
	} else {

		# it is an invalid year
		$result = $this->SetErrorMessage("Invalid year <$year>");

	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Difference In Days - return the difference between two dates in completed days based on Julian days.
# Note: the result can be negative when date1 > date2.
function DifferenceInDays($date1=null, $date2=null) {

	# add to the depth count
	$this->GoDeeper();

	# if date 1 is valid
	if ($good1 = $this->DateIsValid($date1)) {

		# hold the time block for date 1
		$tb1 = $this->GetTheTimeBlock($good1);

		# if date 2 is valid
		if ($good2 = $this->DateIsValid($date2,null ,2)) {

			# hold the time block for date 2
			$tb2 = $this->GetTheTimeBlock($good2);

			# convert to Julian days for first date
			$jdays1 = $this->JulianValue($good1);

			# convert to Julian days for second date
			$jdays2 = $this->JulianValue($good2);

			# result is the second date minus the first
			$result = ($jdays2 - $jdays1);

			# if using time blocks
			if ($this->useTime) {

				# determine which is the greater time block, 1, 2 or 0 = tied
				$tb = $this->GreaterTimeBlock($tb1, $tb2);

				# if the result > zero and time block 1 > time block 2
				if (($result > 0) and ($tb == 1)) {

					# subtract one day
					$result--;

				# elseif the result < zero and time block 2 > time block 1
				} elseif (($result < 0) and ($tb == 2)) {

					# add one day
					$result++;
				# ....
				}
			# ....
			}

		# else
		} else {

			# report date two is invalid date
			$result = $this->SetInvalidDateMessage($date2);
		# ....
		}

	# else
	} else {

		# report date one is invalid date
		$result = $this->SetInvalidDateMessage($date1);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Difference In Weeks - return the difference in complete weeks for the dates given, not partial weeks.
function DifferenceInWeeks($date1=null, $date2=null) {

	# add to the depth count
	$this->GoDeeper();

	# if date 1 is valid
	if ($good1 = $this->DateIsValid($date1)) {

		# if date 2 is valid
		if ($good2 = $this->DateIsValid($date2,null ,2)) {

			# get difference in days
			$days = $this->DifferenceInDays($good1, $good2);

			# divide by 7
			$weeks = $days / 7;

			# drop any fraction
			$result = intval($weeks);

		# else
		} else {

			# report invalid date2
			$result = $this->SetInvalidDateMessage($date2);
		# ....
		}

	# else
	} else {

		# report invalid date1
		$result = $this->SetInvalidDateMessage($date1);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Difference In Years - return the difference between two dates in years, may be negative.
function DifferenceInYears($date1= null, $date2= null) {

	# add to the depth count
	$this->GoDeeper();

	# if date 1 is valid
	if ($good1 = $this->DateIsValid($date1)) {

		# hold the time block for date 1
		$tb1 = $this->GetTheTimeBlock($good1);

		# if date 2 is valid
		if ($good2 = $this->DateIsValid($date2,null ,2)) {

			# hold the time block for date 2
			$tb2 = $this->GetTheTimeBlock($good2);

			# convert dates to arrays of Ymd
			$ymd1 = $this->GetYmdArray($good1);
			$ymd2 = $this->GetYmdArray($good2);

			# initial result is to subtract the years
			$years = $ymd2[0] - $ymd1[0];

			# calculate values for day of the year for both dates
			# this formula avoids cases where Feb 29 = Mar 1
			$doy1 = ($ymd1[1] *100) +$ymd1[2];
			$doy2 = ($ymd2[1] *100) +$ymd2[2];

			# if using time blocks
			if ($this->UseTimeBlocks()) {

				# adjust date 2 when a complete 24 day has not elapsed
				# determine which is the greater time block
				$tb = $this->GreaterTimeBlock($tb1, $tb2);

				# if years > 0 and time block 1 > time block 2
				if (($years > 0) and ($tb == 1)) {

					# subtract one day from 2nd date reducing the span
					$good2 = $this->AddDays(-1, $good2);

				# else if years < 0 and time block 2 > time block 1
				} elseif (($years < 0) and ($tb == 2)) {

					# add one day to 2nd date reducing the span
					$good2 = $this->AddDays(1, $good2);
				# ....
				}

				# redo the YMD array for date 2
				$ymd2 = $this->GetYmdArray($good2);

				# recalculate the value for doy 2
				$doy2 = ($ymd2[1] *100) +$ymd2[2];

			# ....
			}

			# if years is > 0 and doy1 > doy2
			if (($years > 0) and ($doy1 > $doy2)) {

				# subtract one year
				$years--;

			# else years is < 0 and doy1 < day2
			} elseif (($years < 0) and ($doy1 < $doy2)) {

				# add 1 year
				$years++;
			# ....
			}

			# result is the computation of years
			$result = $years;

		# else
		} else {

			# report invalid date 2
			$result = $this->SetInvalidDateMessage($date2);
		# ....
		}

	# else
	} else {

		# report invalid date 1
		$result = $this->SetInvalidDateMessage($date1);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Dow Month Day Year - return a date formatted as day-of-week, month, day, and year.
function DowMonthDayYear($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get the day of the week
		$dow = ucfirst(strtolower($this->DayOfTheWeek($good)));

		# append the month, day, and year
		$result = "$dow {$this->MonthDayYear($good)}";

	# else
	} else {

		 # report invalid date
		 $result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of Next Month - return the end of next month.
function EndOfNextMonth($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# add one month
		$good = $this->AddMonths(1,$good);

		# get the end of that month
		$good = $this->EndOfThisMonth($good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of Next Week- return the end of next week.
function EndOfNextWeek($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get end of its week
		$good = $this->EndOfThisWeek($good);

		# add one week
		$good = $this->AddDays(7, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of Next Year - return the end of next year.
function EndOfNextYear($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get end of its year
		$good = $this->EndOfThisYear($good);

		# add one year to that
		$good = $this->AddYears(1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of Prior Month - return the end of the prior month.
function EndOfPriorMonth($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get its 1st of the month
		$good = $this->FirstOfThisMonth($good);

		# subtract one day
		$good = $this->AddDays(-1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);

	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of Prior Week- return the end of the prior week.
function EndOfPriorWeek($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get first of its week
		$good = $this->FirstOfThisWeek($good);

		# subtract one day
		$good = $this->AddDays(-1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of Prior Year - return the end of the prior year.
function EndOfPriorYear($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get 1st of its year
		$good = $this->FirstOfThisYear($good);

		# subtract one day
		$good = $this->AddDays(-1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of This Month - return the end of the month for the given date.
function EndOfThisMonth($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get 1st of the next  month
		$good = $this->FirstOfNextMonth($good);

		# subtract one day
		$good = $this->AddDays(-1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of This Week - return the end of the week for the given date.
function EndOfThisWeek($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get 1st of its week
		$good = $this->FirstOfThisWeek($good);

		# add 6 days
		$good = $this->AddDays(6, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### End Of This Year - return the end of the year for the given date.
function EndOfThisYear($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get 1st of next year
		$good = $this->FirstOfNextYear($good);

		# subtract one day
		$good = $this->AddDays(-1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of Given Month - return the next first of the month for the given month.
function FirstOfGivenMonth($mon=null, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# if a month string was passed
		if (is_string($mon)) {

			# make it upper case
			$mon = strtoupper($mon);

			# use first 3 characters
			$mon = substr($mon, 0, 3);

			# if the month is in the month array
			if (in_array($mon, $this->monthArray)) {

				# get the next first of the month when the date is not already the first
				$result = $this->NextFirstOfTheMonth($good);

				# loop until the target month matches that in the month array
				while ($mon != $this->MonthStr($result)) {

					# get the 1st of the next month
					$result = $this->AddMonths(1, $result);

				# <---
				}

				# format the resulting date
				$result = $this->FormatADate($result, $fmt);

			# else
			} else {

				# report month is not found in the array
				$result = $this->SetErrorMessage("Invalid month $mon");
			# ....
			}

		# else
		} else {

			# report month is not a string
			$result = $this->SetErrorMessage("Invalid string <$mon>");
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of Next Month - return the 1st of next month after the given date.
function FirstOfNextMonth($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# back up to 1st of its month
		$good = $this->FirstOfThisMonth($good);

		# add one month to that date
		$good = $this->AddMonths(1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First of Next Week - return the 1st of next week after the given date.
function FirstOfNextWeek($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is passed
	if ($good = $this->DateIsValid($date)) {

		# get first the its week
		$good = $this->FirstOfThisWeek($good);

		# add 7 days to that date
		$good = $this->AddDays(7, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of Next Year - return the 1st of next year after the given date.
function FirstOfNextYear($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is passed
	if ($good =$this->DateIsValid($date)) {

		# get the 1st of its year
		$good = $this-> FirstOfThisYear($good);

		# add one year
		$good = $this->AddYears(1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of Prior Month - return the 1st of prior month from the given date.
function FirstOfPriorMonth($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good =$this->DateIsValid($date)) {

		# back up to 1st of its month
		$good = $this->FirstOfThisMonth($good);

		# subtract one month from that date
		$good = $this->AddMonths(-1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of Prior Week- return the 1st of prior week from the given date.
function FirstOfPriorWeek($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is passed
	if ($good =$this->DateIsValid($date)) {

		# get the first of its week
		$good = $this->FirstOfThisWeek($good);

		# subtract 7 days from that date
		$good = $this->AddDays(-7, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of Prior Year - return the 1st of prior year from the given date.
function FirstOfPriorYear($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is passed
	if ($good =$this->DateIsValid($date)) {

		# get the 1st of its year
		$good = $this-> FirstOfThisYear($good);

		# subtract one year
		$good = $this->AddYears(-1, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of This Month - return 1st of the month for the given date.
function FirstOfThisMonth($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is passed
	if ($good =$this->DateIsValid($date)) {

		# get the day of the month
		$dom = $this->DayOfTheMonth($good);

		# subtract one less than the day of the month from the date
		$good = $this->SubtractDays(--$dom, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of This Week - return 1st of the week for the given date.
function FirstOfThisWeek($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is passed
	if ($good =$this->DateIsValid($date)) {

		# get numeric day of the week 0-6
		$dow = $this->NumericDayOfTheWeek($good);

		# subtract that amount from the valid date
		$good = $this->SubtractDays($dow, $good);

		# format the resulting date
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### First Of This Year - return 1st of the year for the given date.
function FirstOfThisYear($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is passed
	if ($good =$this->DateIsValid($date)) {

		# hold the time block
		$tb = $this->GetTheTimeBlock($good);

		# get the YMD array
		$ymd = $this->GetYmdArray($good);

		# build a string for the year and Jan 1
		$first = $ymd[0]  .'0101' ;

		# append the appropriate time block
		$first = $this->AddTimeBlock($first, $tb);

		# format the resulting date
		$result = $this->FormatADate($first, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Get Last Error - return the last error message.
function GetLastError() {

	# return the last error message
	return $this->lastError;

# end function
}

### Greater Date - return the greater of two dates ignoring any null or blank dates. At least one date must be provided.
function GreaterDate($date1=null, $date2=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if date 1 is blank or null
	if (($this->BlankItem($date1) or $this->NullItem($date1))) {

		# its value is zero
		$jd1 = 0;

	# else if date 1 is a date
	} elseif ($this->IsADate($date1)) {

		# get the time block for date 1
		$tb1 = $this->GetTheTimeBlock($date1);

		# convert date 1 to julian only
		$jd1 = $this->JulianValue($date1);

	# else
	} else {

		# it is invalid
		$jd1 = false;
	# ....
	}

	# if date 2 is blank or null
	if (($this->BlankItem($date2) or $this->NullItem($date2))) {

		# its value is zero
		$jd2 = 0;

	# else if date 2 is a date
	} elseif ($this->IsADate($date2)) {

		# get the time block for date 2
		$tb2 = $this->GetTheTimeBlock($date2);

		# convert date 2 to julian
		$jd2 = $this->JulianValue($date2);

	# else
	} else {

		# it is invalid
		$jd2 = false;
	# ....
	}

	# if date 1 is not invalid
	if ($jd1 !== false) {

		# if date 2 is not invalid
		if ($jd2 !== false) {

			# if both dates are zero
			if (($jd1 === 0) and ($jd2 === 0)) {

				# report an error
				$result = $this->SetErrorMessage("Can't have two empty dates.");

			# else
			} else {

				# if $jd2 not a date
				if ($jd2 === 0) {

					# we want date1
					$pick = 1;

				# elseif $jd1 not a date
				} elseif ($jd2 === 0) {

					# we want date2
					$pick = 2;

				# elseif using time blocks and dates are equal, look at optional time blocks
				} elseif (($this->UseTimeBlocks()) and ($jd1 == $jd2)) {

					# if date1 has the greater time block, we want date 1 else date 2
					$pick = ($this->GreaterTimeBlock($tb1, $tb2) == 1)
						?1
						:2;
				# else
				} else {

					# if date 1 is the greater date, we want it else date 2
					$pick = ($jd1 > $jd2)
						? 1
						: 2;
				# ....
				}

				# if we want date 1
				if ($pick ==1) {

					# return date 1
					$result = $this->FormatADate($date1, $fmt);

				# else
				} else {

					# return date2
					$result = $this->FormatADate($date2, $fmt);

				# ....
				}
			# ....
			}

		# else
		} else {

			#report invalid date 2
			$result = $this->SetInvalidDateMessage($date2);
		# ....
		}

	# else
	} else {

		# report invalid date1
		$result = $this->SetInvalidDateMessage($date1);
	# ....
	}

	# return result
	return $this->ReturnResult($result);

# end function
}

### Is A Date - return true when the value passed appears to look like a date. Null and blank are not dates.
function IsADate($date=null) {

	# add to the exception depth count
	$this->GoDeeper();

	# if something is passed and it can be made into a YMD array
	if (($try = trim($date)) and ($this->GetYmdArray($try))) {

		# it is good
		$result = true;

	# else
	} else {

		# if blank is passed
		if ($this->BlankItem($date)) {

			# replace the date with BLANK
			$date = 'BLANK';

		# elseif null is passed
		} elseif ($this->NullItem($date)) {

			# replace the date with NULL
			$date = 'NULL';

		# ....
		}

		# report invalid date
		$result = $this->SetErrorMessage("Invalid date <$date>");
	# ....
	}

	# return true or false
	return $this->ReturnResult($result);

# end function
}

### Is The First - true when the given date is the first of the month, zero when not, false when invalid date is sent.
function IsTheFirst($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good =$this->DateIsValid($date)) {

		# get a YMD array
		$parts = $this->GetYmdArray($good);

		# return true when the day == 1 or zero when not
		$result = ($parts[2] == 1)
			? true
			: 0;

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Julian To Date - convert an integer or integer string to a date string.
function JulianToDate($value=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# save any accompanying time block
	$tb = $this->GetTheTimeBlock($value);

	# get the date part as an integer
	$part = $this->IntegerOrStringValue($this->GetDateOnly($value));

	# if the value passed >= minimum Julian date
	if ($part >= $this->minJulian) {

		# PHP function converts the value to m/d/y string
		$try = jdtojulian($part);

		# append the appropriate time block
		$try = $this->AddTimeBlock($try, $tb);

		# convert the string to a date
		$result = $this->FormatADate($try, $fmt);

	# else
	} else {

		# report invalid integer was passed
		$result = $this->SetInvalidIntegerMessage($value);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Last Dow For A Month - return the last day of the week for the given date - for example: find the last Friday of a month.
function LastDowForAMonth($dayOfWeek, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good = $this->DateIsValid($date)) {

		# get the end of its month
		$try = $this->EndOfThisMonth($good);

		# if the day of the week is valid
		if ($day = $this->DayIsValid($dayOfWeek)) {

			# back up until the day of the week matches
			while (strtoupper($this->DayOfTheWeek($try)) != $day) {

				# subtract one day
				$try = $this->AddDays(-1, $try);

			# <---
			}

			# format the resulting date
			$result = $this->FormatADate($try, $fmt);

		# else
		} else {

			# report an invalid day string is passed
			$result = $this->SetInvalidDowMessage($dayOfWeek);
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Lesser Date - return the lesser of two dates ignoring any null or blank dates. At least one date must be passed.
function LesserDate($date1=null, $date2=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if date 1 is blank or null
	if (($this->BlankItem($date1) or $this->NullItem($date1))) {

		# its value is zero
		$tb1 = $jd1 = 0;

	# else if date 1 is a date
	} elseif ($this->IsADate($date1)) {

		# hold its time block
		$tb1 = $this->GetTheTimeBlock($date1);

		# convert it to julian
		$jd1 = $this->JulianValue($date1);

	# else
	} else {

		# it is invalid
		$jd1 = false;
	# ....
	}

	# if date 2 is blank or null
	if (($this->BlankItem($date2) or $this->NullItem($date2))) {

		# its value is zero
		$tb2 = $jd2 = 0;

	# else if date 2 is a date
	} elseif ($this->IsADate($date2)) {

		# hold its time block
		$tb2 = $this->GetTheTimeBlock($date2);

		# convert it to julian
		$jd2 = $this->JulianValue($date2);

	# else
	} else {

		# it is invalid
		$jd2 = false;
	# ....
	}

	# if date 1 is not invalid
	if ($jd1 !== false) {

		# if date 2 is not invalid
		if ($jd2 !== false) {

			# if both dates passed are empty
			if (($jd1 === 0) and ($jd2 === 0)) {

				# report an error
				$result = $this->SetErrorMessage("Can't have two empty dates");

			# else
			} else {

				# if $jd1 is not a date
				if ($jd1 === 0) {

					# we want date2
					$pick = 2;

				# else if $jd2 not a date
				} elseif ($jd2 === 0) {

					# we want date1
					$pick = 1;

				# elseif using time blocks and dates are equal, look at optional time blocks
				} elseif (($this->UseTimeBlocks()) and ($jd1 == $jd2)) {

					# if date2 has the greater time block, we want date 1 else date 2
					$pick = ($this->GreaterTimeBlock($tb1, $tb2) == 2)
						? 1
						: 2;

				# else
				} else {

					# if date 1 is the lesser date, we want it else date 2
					$pick = ($jd1 < $jd2)
						? 1
						: 2;

				# ....
				}

				# if we want date 1
				if ($pick == 1) {

					# return date 1
					$result = $this->FormatADate($date1, $fmt);

				# else
				} else {

					# return date2
					$result = $this->FormatADate($date2, $fmt);

				# ....
				}
			# ....
			}

		# else
		} else {

			#report invalid date 2
			$result = $this->SetInvalidDateMessage($date2);
		# ....
		}

	# else
	} else {

		# report invalid date1
		$result = $this->SetInvalidDateMessage($date1);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Maximum Date - the maximum of two dates. Null and blank dates default to now.
function MaximumDate($date1=null, $date2=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if date 1 is a valid date
	if ($good1 = $this->DateIsValid($date1)) {

		# if date 2 is also a valid date
		if ($good2 = $this->DateIsValid($date2,null ,2)) {

			# get the greater of the two
			$result = $this->GreaterDate($good1, $good2, $fmt);

		# else
		} else {

			# report invalid date 2
			$result = $this->SetInvalidDateMessage($date2);
		# ....
		}

	# else
	} else {

		# report invalid date 1
		$result = $this->SetInvalidDateMessage($date1);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Minimum Date - the lesser of two dates. Null and blank dates default to now.
function MinimumDate($date1=null, $date2=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if date 1 is a date
	if ($good1 = $this->DateIsValid($date1)) {

		# if date 2 is also a date
		if ($good2 = $this->DateIsValid($date2,null ,2)) {

			# return the lesser of the two dates
			$result = $this->LesserDate($good1, $good2, $fmt);

		# else
		} else {

			# report invalid2
			$result = $this->SetInvalidDateMessage($date2);
		# ....
		}

	# else
	} else {

		# report invalid1
		$result = $this->SetInvalidDateMessage($date1);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Month Day Year - return a date formatted as 'month day, year' like Mar 3, 2005.
function MonthDayYear($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good = $this->DateIsValid($date)) {

		# hold the time block
		$tb = $this->GetTheTimeBlock($good);

		# get a YMD array
		$ymd = $this->GetYmdArray($good);

		# start with the string for the month
		$result = $this->MonthStr($good);

		# add the day, comma and year
		$result .= ' ' .$ymd[2] .', ' .$ymd[0];

		# append the approprite time block
		$result = trim("$result $tb");

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Month Number - the integer month number for the named month.
function MonthNumber($mon=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a string is passed
	if (is_string($mon)) {

		# use just the 1st three characters
		$mon = substr($mon, 0, 3);

		# make it upper case for searching the month array
		$mon = strtoupper($mon);

		# if the month is in the month array
		if (in_array($mon, $this->monthArray)) {

			# return its position in the month array
			$result = array_search($mon, $this->monthArray);

			# because arrays begin with zero, add 1 to it
			$result++;

		# else
		} else {

			# report the month is not in the month array
			$result = $this->SetErrorMessage("Unrecognized <$mon>");
		# ....
		}

	# else
	} else {

		# not a string
		$result = $this->SetErrorMessage("Unrecognized <$mon>");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Month Str - return the 3-char string for the month of the given date.
function MonthStr($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date is given
	if ($good = $this->DateIsValid($date)) {

		# get a YMD array
		$ymd = $this->GetYmdArray($good);

		# hold the numeric month
		$m =$ymd[1];

		# get 3-char month from the public array
		$result = $this->monthArray[--$m];

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### N Days Before End Of The Month - return N days before the end of the month for the given date.
function NDaysBeforeEndOfTheMonth($n=0, $date = null, $fmt= null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good=$this->DateIsValid($date)) {

		# hold month and year for the date
		$monYr = $this->MonYear($good);

		# get end of the month for the date
		$good = $this->EndOfThisMonth($good);

		# if n is an integer or integer string
		$cnt = $this->IntegerOrStringValue($n);
		if ($cnt !== false) {

			# subtract N days
			$good = $this->SubtractDays($cnt, $good);

			# if still in the same month and year
			if ($this->MonYear($good) == $monYr) {

				# return formatted date
				$result = $this->FormatADate($good, $fmt);

			# else
			} else {

				# report invalid value for N
				$result = $this->SetInvalidIntegerMessage($n);
			# ....
			}

		# else
		} else {

			# report invalid value for N
			$result = $this->SetInvalidIntegerMessage($n);
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return result
	return $this->ReturnResult($result);

# end function
}

### Next Day Of The Week - return the next date for a named day of the week when given date is not same as the day sent.
function NextDayOfTheWeek($dayOfWeek, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good=$this->DateIsValid($date)) {

		# if the day of the week is valid
		if ($day = $this->DayIsValid($dayOfWeek)) {

			# loop until the days of the week match
			while (strtoupper($this->DayOfTheWeek($good)) != $day) {

				# add one day
				$good = $this->AddDays(1, $good);

			# <---
			}

			# format the resulting date
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# report an invalid day string was passed
			$result = $this->SetInvalidDowMessage($dayOfWeek);
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Next First Of The Month - the next first of the month if the given date is not the 1st.
function NextFirstOfTheMonth($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# if the given date is not the 1st of the month,
		if (! $this->IsTheFirst($good)) {

			# get the first of the next month
			$good = $this->FirstOfNextMonth($good);
		# ....
		}

		# format the result
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Next First Of The Year - the next first of the year if the given date is not the 1st.
function NextFirstOfTheYear($date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# get the day of the year
		$dow = $this->DayOfTheYear($good);

		# if the given date is not the first of the year
		if ($dow != 1) {

			# get 1st of next year
			$good = $this->FirstOfNextYear($good);
		# ....
		}

		# format the result
		$result = $this->FormatADate($good, $fmt);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Next Nth Day Of The Month - the next Nth day of the month after the given date, e.g. 3rd Tuesday.
function NextNthDayOfTheMonth($n=1, $dayOfWeek, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good=$this->DateIsValid($date)) {

		# if N is between 1 and 5
		if ( $this->IntegerRange($n, 1, 5)) {

			# if a known day of the week was passed
			if ($this->DayIsValid($dayOfWeek)) {

				# get the date for the next day of the week
				$good = $this->NextDayOfTheWeek($dayOfWeek, $good);

				# loop until the date is found
				while (true) {

					# get day of the month for the date to examine
					$dom = $this->DayOfTheMonth($good);

					# if N=5 and day of the month >= 29,
					if (($n == 5) and ($dom >= 29)) {
						# date is found so break the loop
						break;

					# elseif N=4 and day of the month between 22 - 28
					}elseif (($n == 4) and ($this->IntegerRange($dom, 22, 28))) {
						# date is found so break the loop
						break;

					# elseif N=3 and day of the month between 15 - 21
					} elseif (($n == 3) and ($this->IntegerRange($dom, 15, 21))) {
						# date is found so break the loop
						break;

					# elseif N=2 and day of the month between 8 - 14
					} elseif (($n == 2) and ($this->IntegerRange($dom,8,14))) {
						# date is found so break the loop
						break;

					# elseif N=1 and day of the month <= 7
					} elseif (($n == 1) and ($dom <= 7)) {
						# date is found so break the loop
						break;
					# ....
					}

					# add 1 week and try again
					$good = $this->AddWeeks(1, $good);

				# <---
				}

				# format the date found
				$result = $this->FormatADate($good, $fmt);

			# else
			} else {
				# report invalid day of the week
				$result = $this->SetInvalidDowMessage($dayOfWeek);
			# ....
			}

		# else
		} else {

			# report invalid value for N
			$result = $this->SetInvalidIntegerMessage($n);
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Next Nth Of The Month - advance as needed to the next Nth day of a month limited to 1-31.
function NextNthOfTheMonth($n=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# treat N as an integer
		$n = $this->IntegerOrStringValue($n);

		# if N is between 1 and 31
		if (($n !== false) and ($this->IntegerRange($n, 1, 31))) {

			# get the day of the month for the given date
			$dp= $this->DayOfTheMonth($good);

			# if day for the given date is after the target N
			$good = ($dp > $n)

				# get 1st of next month
				? $this->FirstOfNextMonth($good)

				# else get 1st of the month passed
				: $this->FirstOfThisMonth($good);
			# ....

			# if not that many days in the trial month
			if ($this->NumberOfDaysInAMonth($good) < $n) {

				# add one month
				$good = $this->AddMonths(1, $good);
			# ....
			}

			# advance to the Nth of the month found
			$nth = $this->AddDays(--$n, $good);

			# return the date
			$result = $this->FormatADate($nth, $fmt);

		# else
		} else {

			# invalid value for N
			$result = $this->SetInvalidIntegerMessage($n);
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Nth Of The Month - return Nth day of the month for the given date limited to 1-31.
function NthOfTheMonth($n=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good = $this->DateIsValid($date)) {

		# if N is between 1 and 31
		if ($this->IntegerRange($n, 1, 31)) {

			# hold the month for the date sent
			$sent = $this->NumericMonth($good);

			# get end of prior month
			$good = $this->EndOfPriorMonth($good);

			# apply the N increment to end of the prior month
			$good2 = $this->AddDays($n, $good);

			# get the month for the calculated date
			$calc = $this->NumericMonth($good2);

			# if the month sent and calculated are the same
			if ($sent == $calc) {

				# make returning date
				$result = $this->FormatADate($good2, $fmt);

			# else
			} else {

				# report an error: it can not be determined
				$monYear = $this->MonYear($date);
				$result = $this->SetErrorMessage("Invalid <$n> day for $monYear");
			# ....
			}

		# else
		} else {

			# report invalid value for N
			$result = $this->SetInvalidIntegerMessage($n);
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Number Of Days In A Month - return a count of the number of days in a month.
function NumberOfDaysInAMonth($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good = $this->DateIsValid($date)) {

		# get the end of the month for the date
		$good = $this->EndOfThisMonth($good);

		# return that day of that month
		$result = $this->DayOfTheMonth($good);

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Numeric Day Of The Week - return the numeric day of the week 0-6 based on the public day array.
function NumericDayOfTheWeek($date=null) {

	# add to the depth count
	$this->GoDeeper();

	$good = $this->DefaultDate($date);

	# if date can be made into a julian date
	if ($d = $this->JulianValue($good)) {

		# get the difference between it and the julian base date -- which is the start of a week
		$diff = $d - $this->julianBase;

		# compute modulo 7
		$result = $diff %7;

		# if negative (earlier than the base date)
		if ($result < 0) {
			# add 7
			$result +=7;
		# ....
		}

	# else
	} else {

		# report an invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Numeric Month - return the numeric month (1-12) for the given date.
function NumericMonth($date = null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good = $this->DateIsValid($date)) {

		# make a YMD array
		$ymd = $this->GetYmdArray($good);

		# return the month part
		$result = $ymd[1];

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Numeric Year - return the numeric year for the given date.
function NumericYear($date = null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good = $this->DateIsValid($date)) {

		# make a YMD array
		$ymd = $this->GetYmdArray($good);

		# return the year part
		$result = $ymd[0];

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Prior Day Of The Week - return the date for the prior day of the week from the given date. Back up, if needed.
function PriorDayOfTheWeek($dayOfWeek, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if a valid date was passed
	if ($good=$this->DateIsValid($date)) {

		# if a known day of the week is passed
		if ($day = $this->DayIsValid($dayOfWeek)) {

			# while the day of the week is not what we want
			while ($this->DayOfTheWeek($good) != $day) {

				# subtract one day
				$good = $this->AddDays(-1, $good);
			# <---
			}

			# format the result
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# report an invalid day string is passed
			$result = $this->SetInvalidDowMessage($dayOfWeek);
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);
# end function
}

### Subtract Days - subtract absolute number of days from the given date.
function SubtractDays($days=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if days are given as an integer or integer string
	if ($this->IntegerOrStringValue($days) !== false) {

		# if input is a valid date
		if ($good = $this->DateIsValid($date)) {

			# use absolute value of days to subtract
			$count = abs((int) $days);

			# multiply by -1
			$count *= -1;

			# add negative days
			$good = $this->AddDays($count, $good);

			# format the resulting date
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# report invalid date
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# report an error with days
		$result = $this->SetErrorMessage("Invalid number of days <$days>");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);
# end function
}

### Subtract Months - subtract absolute number of months from the given date.
function SubtractMonths($months=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if months are given as an integer or integer string
	if ($this->IntegerOrStringValue($months) !== false) {

		# use absolute value of months to subtract
		$months = abs((int) $months);

		# multiply by -1
		$months *= -1;

		# if adding negative months yields a good date
		if ($good = $this->AddMonths($months, $date)) {

			# format the resulting date
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# report invalid date
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# report error with months
		$result = $this->SetErrorMessage("Invalid number of months <$months>");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Subtract Weeks - subtract absolute number of weeks from the given date.
function SubtractWeeks($weeks=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if weeks are given as an integer or integer string
	if ($this->IntegerOrStringValue($weeks) !== false) {

		# if a valid date was passed
		if ($good=$this->DateIsValid($date)) {

			# use absolute value of weeks to subtract
			$weeks = abs((int) $weeks);

			# calculate days to subtract by multiplying weeks by -7
			$days = $weeks *(-7);

			# subtract those days
			$good = $this->AddDays($days, $good);

			# format the resulting date
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# report invalid date
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# report error with weeks
		$result = $this->SetErrorMessage("Invalid number of weeks <$weeks>");

	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Subtract Years - subtract absolute number of years from the given date.
function SubtractYears($years=0, $date=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# if years are given as an integer or integer string
	if ($this->IntegerOrStringValue($years) !== false) {

		# use absolute value of years *12 to subtract months
		$months = abs((int) $years) *12;

		# if subtracting that many months results in a good date
		if ($good = $this->SubtractMonths($months, $date)) {

			# format the resulting date
			$result = $this->FormatADate($good, $fmt);

		# else
		} else {

			# report invalid date
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# else
	} else {

		# report an error with years
		$result = $this->SetErrorMessage("Invalid number of years <$years>");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Use Exceptions - opt to set exceptions on or off and return the state.
function UseExceptions($state=null) {

	# if null is not passed
	if (! is_null($state)) {

		# anything that evaluates to true
		$state = ($state)
			# turns on exceptions
			? true
			# else turned off
			: false;

		# set the state for using exceptions
		$this->exceptions = $state ;

	# ....
	}

	# return the state
	return $this->exceptions;

# end function
}

### Use Time Blocks - opt to set using time blocks on or off and return the state.
function UseTimeBlocks($state=null) {

	# if null is not passed
	if (! is_null($state)) {

		# anything that evaluates to true
		$state = ($state)

			# turns on time blocks
			? true
			# else turned off
			: false;

		# set the state for using exceptions
		$this->useTime = $state ;
	# ....
	}

	# return the state
	return $this->useTime;

# end function
}

### Week Number - return the week number (0-53) of the year, weeks begin on the first day in the day array.
function WeekNumber($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# if the date is valid
	if ($good=$this->DateIsValid($date)) {

		# get the 1st of its year
		$jan1 = $this->FirstOfThisYear($good);

		# get 1st of the week for Jan 1
		$day0 = $this->FirstOfThisWeek($jan1);

		# get the difference between day zero of the year and desired date
		$diff = $this->DifferenceInDays($day0, $good) ;

		# week number is the integer value of difference divided by 7
		$result = intval($diff / 7);

		# if Jan 1 is also day 0
		if ($jan1 == $day0) {

			# add one to the week
			$result++;
		# ....
		}

	# else
	} else {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Ymd - convert a date to an array of year, month, day from a date. Optional time block.
function Ymd($date=null) {

	# add to the depth count
	$this->GoDeeper();

	# default to today when null or blank date
	$good = $this->DefaultDate($date);

	# try to get a YMD array
	$result = $this->GetYmdArray($good);

	# if no result was found
	if ($result === false) {

		# report invalid date
		$result = $this->SetInvalidDateMessage($date);

	# else if using time blocks
	} elseif($this->UseTimeBlocks()) {

		# get the time block when used
		$tb = $this->GetTheTimeBlock($good);

		# attach the time block to the resulting array
		$result[3] = $tb;
	# ....
	}

	# return either an array or false
	return $this->ReturnResult($result);

# end function
}

### Ymd Array To Date - convert a YMD array to a date string.
function YmdArrayToDate($ymdArray=null, $fmt=null) {

	# add to the depth count
	$this->GoDeeper();

	# assume the array is bad
	$result = false;

	# count the array elements
	$cnt = count($ymdArray);

	# if a numeric array of 3 or 4 values was passed: year , month, day opt time block
	if ($this->IntegerRange($cnt, 3, 4)) {

		# if non-zero integers or integer strings are given
		if (($ymdArray[0] = $this->IntegerOrStringValue($ymdArray[0])) and
				($ymdArray[1] = $this->IntegerOrStringValue($ymdArray[1])) and
				($ymdArray[2] = $this->IntegerOrStringValue($ymdArray[2]))) {
			$a[0] = sprintf('%04u',$ymdArray[0]);
			$a[1] = sprintf('%02u',$ymdArray[1]);
			$a[2] = sprintf('%02u',$ymdArray[2]);

			# build a date string
			$try = implode('-', $a);

			# if it makes a valid date
			if ($this->IsADate($try)) {

				# if there is a 4th element
				if ($cnt == 4) {

					# add it to the date
					$try = $this->AddTimeBlock($try, $ymdArray[3]);
				# ....
				}

				# format the good resulting date
				$result = $this->FormatADate($try, $fmt);

			# ....
			}
		# ....
		}
	# ....
	}

	# if still a bad result
	if ($result === false) {

		# report invalid array
		$result = $this->SetErrorMessage("Invalid array");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

### Ymd String To Date - convert a string in the form of yyyymmdd to a date. Optional time block.
function YmdStringToDate($yyyymmdd=null, $fmt=null) {

	# add to the depth count
	$depth = $this->GoDeeper();

	# assume a bad result
	$result = false;

	# if a string is passed
	if (is_string($yyyymmdd)) {

		# trim leading and trailing blanks
		$yyyymmdd = trim($yyyymmdd);

		# explode the string into date / time
		$parts = explode(' ', $yyyymmdd, 2);

		# test the date part
		$try = $parts[0];

		# if no non-digits
		if ( ! preg_match('/[^0-9]/', $try)) {

			# if it has exactly 8 digits
			if (strlen($try) == 8) {

				# if there is a time element
				if (count($parts) == 2) {

					# add it to the date
					$try = $this->AddTimeBlock($try, $parts[1]);
				# ....
				}

				# if the date is valid
				if ($this->DateIsValid($try)) {

					# format a good resulting date
					$result = $this->FormatADate($try, $fmt);

				# ....
				}
			# ....
			}
		# ....
		}
	# ....
	}

	# if still a bad result
	if ($result === false) {

		# report invalid date
		$result = $this->SetErrorMessage("Invalid date string '$yyyymmdd' ");
	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

######## Private functions #####

### Add Time Block - return a date with time block appended when time blocks are used
private function AddTimeBlock($date, $tb=false) {

	# get just the date
	$result = $this->GetDateOnly($date);

	# if using time blocks
	if ($this->UseTimeBlocks()) {

		# if there is a time block passed
		if ($tb) {

			# append the passed time block to the date
			$result .= " $tb" ;

		# ....
		}

	# ....
	}

	# return result
	return $result;

# end function
}

### Blank Item - true when what is passed is a blank string.
private function BlankItem($item) {

	# return true if it is a string and trimmed length is zero
	return ((is_string($item)) and (strlen(trim($item)) == 0)) ;

# end function
}

### Day Is Valid - return 3-char day when the day is in the week-day array.
private function DayIsValid($dayOfWeek) {

	# add to the depth count
	$this->GoDeeper();

	# convert to upper case
	$day = strtoupper($dayOfWeek);

	# use just the 1st three characters
	$day = substr($day, 0, 3);

	# if the day of the week is in the day array
	if (in_array($day, $this->dayArray)) {

		# return the day
		$result = $day;

	# else
	} else {

		# return false
		$result = false;
	# ....
	}

	# return result
	return $this->ReturnResult($result);

# end function
}

### Default Date - default a date to today when the date is null or blank. This does not validate the date.
private function DefaultDate($date=null) {

	# if date is null or blank
	if (($this->NullItem($date)) or ($this->BlankItem($date))) {

		# if using time blocks
		if ($this->UseTimeBlocks()) {

			# return today with a time block.
			$result =  date("Y-m-d H:i:s");

		# else
		} else {

			# return just the date
			$result =  date("Y-m-d");

		# ....
		}

	# else
	} else {

		# return the date sent
		$result = $date;
	# ....
	}

	# return the result
	return $result;

# end function
}

### Format A Date - format a date using the requested format string.
private function FormatADate($date, $fmt=null) {

	# be sure we have a valid formatting string
	$fmt = $this->ValidFormat($fmt);

	# if a YMD array can be made which it always should be
	if ($ymd = $this->GetYmdArray($date)) {

		# hold the time block
		$tb =$this->GetTheTimeBlock($date);

		# determine the desired separator: slash, dash, dot or none for the return format
		# if a slash
		if (strpos($fmt, '/')) {
			# separate with /
			$sep = '/';

		# elseif a dash
		} elseif (strpos($fmt, '-')) {
			# separate with -
			$sep = '-';

		# elseif a dot
		} elseif (strpos($fmt, '.')) {
			# separate with .
			$sep = '.';

		# else
		} else {
			# no separator
			$sep = '';
		# ....
		}

		# only three output arrangements are used -- y,m,d or m,d,y or d,m,y with or without a separator
		# if m comes first in the output format,
		if (strpos($fmt, 'm') === 0) {

			# it is month first
			$out = array($ymd[1], $ymd[2], $ymd[0]);

		# elseif the day is first
		} elseif (strpos($fmt, 'd') === 0) {

			# it is d m y
			$out = array($ymd[2], $ymd[1], $ymd[0]);

		# else
		} else {

			# the year comes first
			$out = $ymd;
		# ....
		}

		# build the resulting date with the chosen separator
		$result = implode($sep, $out);

		# add the appropriate time block
		$result = $this->AddTimeBlock($result, $tb);

	# else
	} else {

		# bad date was sent which should never happen - return false
		$result = false;
	# ....
	}

	# return the result
	return $result;

# end function
}

### Fresh Start - set global variables for a fresh start.
private function FreshStart() {

	$this->validDate[1] = false;
	$this->validDate[2] = false;
	$this->depth =  0;

# end function
}

### Get Date Only - get the date part without the time block.
private function GetDateOnly($date) {

	# trim any leading or trailing blanks from the date
	$date = trim($date);

	# separate the date into 2 parts at most
	$dd = explode(' ', $date, 2);

	# return the date part
	return $dd[0];

# end function
}

### Get The Time Block - return an appropriate time block from a date.
private function GetTheTimeBlock($date) {

	# if using time blocks
	if ($this->UseTimeBlocks()) {

		# trim any leading or trailing blanks from the date
		$date = trim($date);

		# replace multiple spaces with one space
		$date = str_replace(array('  ', '   '), ' ', $date);

		# separate the date into 2 pieces at most
		$dd = explode(' ', $date, 2);

		# if two elements are found and a valid time block is present
		if ((count($dd) == 2) and ($result = $this->ValidTimeBlock($dd[1]))) {
			# we captured it
			;

		# else
		} else {

			# set time block to 00:00
			$result= '00:00' ;
		# ....
		}

	# else
	} else {

		# return blank
		$result = '';

	# ....
	}

	# return the time block
	return $result;

# end function
}

### Get a YMD array with any time block removed.
private function GetYmdArray($date, $includeTime=true) {

	# remove any time block
	$date = $this->GetDateOnly($date);

	# assume the result is false
	$result = false;

	# if exactly 8 characters and all are digits, treat it as yyyymmdd
	if ((strlen($date) == 8) and strlen($this->StringOfDigitsOnly($date)) == 8) {

		# divide it into an array of 3 parts
		$ar[0] = substr($date, 0, 4);
		$ar[1] = substr($date, 4, 2);
		$ar[2] = substr($date, 6, 2);

		# if year >= 32 and it checks good
		if ((checkdate($ar[1], $ar[2], $ar[0])) and ($ar[0] >= 32)) {

			# return the array
			$result = $ar;

		# else
		} else {

			# report invalid date
			$result = $this->SetInvalidDateMessage($date);
		# ....
		}

	# elseif the date uses - . or / in its format
	} elseif (	preg_match('|[/.-]|', $date)) {

		# convert any / to dash
		$date = str_replace('/','-', $date);

		# convert any . to dash
		$date = str_replace('.','-', $date);

		# separate the string into parts on the dash
		$ar = explode('-', $date);

		# rebuild date as an integer and as a string with digits only
			# because non-digits are not valid

		$do = implode('',$ar);
		$doInt = (int) $do;
		$do = $this->StringOfDigitsOnly($do);

		# if exactly 3 parts are found, and string value == integer value
		if ((count($ar) == 3) and ($do == $doInt)) {

			# if year >= 32 and checkdate says the y,m,d checks
			if (($ar[0] >= 32) and (checkdate($ar[1], $ar[2], $ar[0]))) {

				# it is a good array
				$result = $ar;

			# elseif checkdate verifies it as as m,d,y and year >= 32
			} elseif ((checkdate($ar[0], $ar[1], $ar[2])) and ($ar[2] >= 32)) {

				# rebuild the array as y,m,d
				$result = array($ar[2],$ar[0],$ar[1]);

			# ....
			}

			# if the result is a valid array
			if (is_array($result)) {
				# make sure month and day have 2 digits each and year has 4
				$result[0] = str_pad($result[0], 4, '0',STR_PAD_LEFT);
				$result[1] = str_pad($result[1], 2, '0',STR_PAD_LEFT);
				$result[2] = str_pad($result[2], 2, '0',STR_PAD_LEFT);

			# ....
			}
		# ....
		}
	# ....
	}

	# return either an array or false
	return $result;

# end function
}

### Go Deeper - add one to the internal depth count.
private function GoDeeper() {

	# add 1 to the exception depth
	$this->depth++;

	# return the depth
	return $this->depth;

# end function
}

### Go Up - subtract one from the depth count.
private function GoUp() {

	# subtract one count
	$this->depth--;

	# depth should never be negative
	$this->depth = max($this->depth, 0);

# end function
}

### Greater Time Block - return the greater of two time blocks (1, 2, or zero when identical).
private function GreaterTimeBlock($tb1 = '0:0', $tb2 ='0:0' ) {

	# convert time 1 to seconds since midnight
	$t1 = $this->TimeBlockValue($tb1);

	# convert time 2 to seconds since midnight
	$t2 = $this->TimeBlockValue($tb2);

	# if very same time
	if ($t1 == $t2) {

		# return zero
		$result = 0;

	# else
	} else {

		# return the greater of time 1 or time 2
		$result = ($t1 > $t2)
			? 1
			: 2;
	# ....
	}

	# return 0, 1, or 2
	return $result;

# end function
}

### Integer Or String Value - return the value as an integer.
private function IntegerOrStringValue($in= false) {

	# if a string is given
	if (is_string($in)) {

		# trim blanks
		$in = trim($in);

		# if anything other than integer characters
		if (preg_match('/[^0-9-+]/', $in)) {

			# return false
			$result = false;

		# else
		} else {

			# convert to integer
			$result = intval($in);
		# ....
		}

	# elseif an integer
	} elseif (is_int($in)) {

		# return it, which may be zero
		$result = $in;

	# else
	} else {

		# return false
		$result = false;

	# ....
	}

	# return the result
	return $result;

# end function
}

### Integer Range - true when a value is in the 'from' and 'to' range.
private function IntegerRange($x, $from, $to) {

	# if X is an  invalid integer or integer string
	if ($this->IntegerOrStringValue($x) === false) {

		# result is false
		$result = false;

	# else
	} else {

		# since this is used only internally, integers or integer string values are assummed
		$x = (int) $x;
		$from = (int) $from;
		$to = (int) $to;

		# if x >= from and <= to,
		$result = (($x >= $from) and ($x <= $to));

	# ....
	}

	# return result
	return $result;

# end function
}

### Julian Value - convert a date to Julian integer without the time block.
private function JulianValue($date) {

	# if a real date is given
	if ($this->IsADate($date)) {

		# make the date into YMD array
		$ymd = $this->GetYmdArray($date);

		# convert to Julian days from date (m, d, y)
		$result = juliantojd($ymd[1], $ymd[2], $ymd[0]);

	# else
	} else {

		# return false
		$result = false;
	# ....
	}

	# return result
	return $result;

# end function
}

### Mon Year - format a date as 'mon year' like Mar 2005.
private function MonYear($date=null) {

	# get a ymd array
	$ymd = $this->GetYmdArray($date);

	# the month string and year
	$result = $this->MonthStr($date) .' ' .$ymd[0];

	# return the result
	return $result;

# end function
}

### Null Date - true when what is passed is null.
private function NullItem($item=null) {

	# return true when the item passed is null
	return ($item === null) ;

# end function
}

### Return Result - go up one level in the depth and return the given result.
private function ReturnResult($result) {

	# go up one level
	$this->GoUp();

	# if at  depth zero  we are where the first date_math function was called
	if ($this->depth === 0) {

		# reset globals to a fresh start
		$this->FreshStart();

	# ....
	}

	# return result
	return $result;

# end function
}

### Set Error Message - set an error message in the public error variable.
private function SetErrorMessage($msg, $goback=1) {

	# get the call stack
	$stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

	# if the 'goback' stack has the desired entry - either 1 , 2 or 3 back
	if (isset($stack[$goback])) {

		# return the name of the 'goback' function
		$cameFrom = $stack[$goback]['function'];

	# else
	} else {

		# error came from the main function
		$cameFrom = 'Main';
	# ....
	}

	# record the error in public variable
	$this->lastError = "$msg passed to function '$cameFrom' ";

	# if at depth 1 - the function was called from your script
	if ($this->depth == 1) {

		# reset variables
    		$this->FreshStart();

		# if throwing exceptions
		if ($this->UseExceptions()) {

			# throw the exception
			throw new Exception($this->lastError);
		# ....
		}
	# ....
	}

	# always return false
	return false;

# end function
}

### Set Invalid Date Message in the public variable  for the lastError.
private function SetInvalidDateMessage($x) {

	# build and return the message
	return $this->SetInvalidMsg( "Invalid date <$x>", $back=3);

# end function
}

### Set Invalid Day Of Week Message in the public variable  for the lastError.
private function SetInvalidDowMessage($x) {

	# build and return the message
	return $this->SetInvalidMsg( "Invalid week day <$x>", 3);

# end function
}

### Set Invalid Integer Message in the public variable  for the lastError.
private function SetInvalidIntegerMessage($x) {

	# build and return the invalid integer message
	return $this->SetInvalidMsg( "Invalid integer <$x>", 3);

# end function
}

### Set An Invalid Message in the public variable  for the lastError.
private function SetInvalidMsg($msg='', $back = 2) {

	# set the error message and the name of the function being called.
	return $this->SetErrorMessage($msg, $back);

# end function
}

### String of Digits Only - returns only digits 0-9 as a string which may have leading zeros.
private function StringOfDigitsOnly($in=null) {

	# start with a blank result
	$result = '';

	# if an integer is given
	if (is_int($in)) {

		# cast it as a string
		$result = (string)$in;

	# elseif a string is given
	} elseif (is_string($in)) {

		# loop thru the string
		for ($i = 0; $i < strlen($in); $i++ ) {

			# if the character is a digit 0-9,
			if (strpos('0123456789', $in[$i]) !== false) {

				# retain it
				$result .= $in[$i];
			# ....
			}
		# <---
		}

	 # else
	} else {

		# error: neither a string nor integer
		$result = false;
	# ....
	}

	# return the result
	return $result;

# end function
}

### Time Block Value - return the integer value in seconds since midnight of a time block.
private function TimeBlockValue($aTime=false) {

	# if other than blank or null and a valid time
	if (($aTime = trim($aTime)) and ($this->ValidTimeBlock($aTime) !== false)) {

		# AM and PM need to be upper case
		$aTime = strtoupper($aTime);

		# break out the optional AM PM
		$major = explode(' ', $aTime, 2);

		# break out hours minutes and seconds
		$minor = explode(':', $major[0]);

		# compute hours as seconds
		$result = $minor[0] *60 *60;

		# add each minute as 60 seconds
		$result += $minor[1] *60;

		# if any seconds
		if (count($minor) > 2) {

			# add them to the result
			$result += $minor[2];
		# ....
		}

		# if PM is set
		if ((count($major) > 1) and ($major[1] == 'PM')) {

			# add 43200 seconds (12*60*60)
			$result += 43200;
		# ....
		}

	# else return zero
	} else {

		# return blank
		$result = 0;
	# ....
	}

	# return the result
	return $result;

# end function
}

### Valid Format - return a valid format string.
private function ValidFormat($fmt=null) {

	# if theformat string passed is null
	if (is_null($fmt)) {

		# use the default format
		$fmt = $this->defaultFormat;

	# else
	} else {

		# convert format string to lower case
		$fmt = strtolower($fmt);

		# replace dd, mm, yy yyyy with just one of each
		$fmt = str_replace(array('dd','mm','yy','yy') ,array('d','m','y','y'), $fmt);

		# if format string does not have exactly one each of d m y (chr 100, 109, 121)
		$chars = count_chars($fmt, 0);
		if (($chars[100] != 1) or ($chars[109] != 1) or ($chars[121] != 1)) {

			# revert to the default format
			$fmt = $this->defaultFormat;
		# ....
		}
	#....
	}

	# return a good format string
	return $fmt;
# end function
}

### Valid Time Block - return the time block when it is valid.
private function ValidTimeBlock($aTime = null) {

	# add to the depth count
	$this->GoDeeper();

	# assume it is valid
	$valid = true;

	# remove any leading and trailing blanks
	$aTime = trim($aTime);

	# if blank or null
	if (($this->NullItem($aTime)) or ($this->BlankItem($aTime))) {

		# it is not invalid
		$valid = false;

	# elseif any character is not in the character set for time
	} elseif (preg_match('/[^0-9AaMmPp: ]/', $aTime)) {

		# it is not invalid
		$valid = false;

	# else
	} else {

		# separate the optional AM PM
		$major = explode(' ', $aTime);

		# if more than two elements
		if (count($major) > 2) {

			# it is not valid
			$valid = false;
		# ....
		}

		# separate hours minutes and seconds
		$minor = explode(':', $major[0]);

		# if no minutes
		if (! isset($minor[1])) {

			# it is not invalid
			$valid = false;

		# elseif minutes outside the range of 0-59
		} elseif (! $this->IntegerRange($minor[1], 0, 59)) {

			# it is not invalid
			$valid = false;

		# elseif two parts to the time block - should have AM or PM
		} elseif (count($major) == 2) {

			# if hours outside 0 - 12
			if (! $this->IntegerRange($minor[0], 0, 12)) {

				# it is not invalid
				$valid = false;

			# elseif AM PM is not exactly 2 haracters long
			} elseif (strlen($major[1]) != 2) {

				# it is not valid
				$valid = false;

			# elseif not either AM or PM
			} elseif ( ! preg_match('/AM|PM/i', $major[1])) {

				# it is not valid
				$valid = false;

			# ....
			}

		# elseif hours outside 0-23
		} elseif (! $this->IntegerRange($minor[0], 0, 23)) {

			# it is not invalid
			$valid = false;
		# ....
		}

		# if seconds are present
		if (count($minor) > 2) {

			# if outside the range of 0-59
			if (! $this->IntegerRange($minor[2], 0, 59)) {

				# it is not invalid
				$valid = false;
			# ....
			}
		# ....
		}

	# ....
	}

	# if valid
	if ($valid) {

		# return the time block
		$result = $aTime;

	# else
	} else {

		# enter an error message and return false
		$result = $this->SetErrorMessage("Invalid time block '$aTime'");

	# ....
	}

	# return the result
	return $this->ReturnResult($result);

# end function
}

# end class
}
?>